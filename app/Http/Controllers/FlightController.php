<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Flights;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\Flight_details;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FlightController extends Controller
{
    public function index(): View
    {
        $perPage = request()->input('per_page', 30);
        $flights = Flights::orderBy('arrival', 'asc')->paginate($perPage)->withQueryString();

        return view('flight.index', compact('flights'));
    }

    public function store(Request $request)
    {
        try {
            $userStation = auth()->user()->station;
            $arrivalDateTime = Carbon::parse($request->arrival);
            $arrivalDate = $arrivalDateTime->toDateString();
            $flightTime = $arrivalDateTime->format('H:i:s');

            // Cek apakah flight sudah ada (Pencegahan duplikasi) berdasarkan stasiun dan tanggal kedatangan
            $exists = Flights::where('flight_number', $request->flight_number)
                ->where('station', $userStation)
                ->whereDate('created_at', $arrivalDate)
                ->exists();

            if ($exists) {
                Alert::warning('Peringatan', 'Nomor penerbangan ' . $request->flight_number . ' sudah terdaftar untuk stasiun dan tanggal tersebut.');
                return redirect()->route('home');
            }

            $flight = new Flights();
            $flight->airline = $request->airline;
            $flight->flight_number = $request->flight_number;
            $flight->registasi = $request->registasi;
            $flight->type = $request->type;
            $flight->arrival = $flightTime; // Simpan jam kedatangan
            $flight->time_count = Carbon::parse($request->time_count)->format('H:i:s');
            $flight->station = $userStation; // Set stasiun sesuai stasiun user yang login
            $flight->status = 0;
            $flight->created_at = $arrivalDateTime; // Set created_at agar filter tanggal di dashboard sesuai dengan tanggal penerbangan
            $flight->save();

            $flightNumber = strtoupper($flight->flight_number);
            $type = strtolower($flight->type);

            if (str_starts_with($flightNumber, 'PR')) {
                $requiredPeople = 8;
            } elseif (str_starts_with($flightNumber, 'QF')) {
                $requiredPeople = $type === 'widebody' ? 4 : 6;
            } else {
                $requiredPeople = $type === 'widebody' ? 4 : 6;
            }

            // Ambil shift yang aktif pada jam kedatangan (Mendukung shift malam/overnight)
            $activeShifts = Shift::all()->filter(function ($shift) use ($flightTime) {
                $start = $shift->start_time;
                $end = $shift->end_time;
                if ($start <= $end) {
                    return $flightTime >= $start && $flightTime <= $end;
                } else {
                    // Shift malam melewati tengah malam (contoh: 20:00:00 s.d 06:00:00)
                    return $flightTime >= $start || $flightTime <= $end;
                }
            });

            if ($activeShifts->isEmpty()) {
                Alert::error('Gagal', 'Tidak ada shift aktif untuk jam penerbangan tersebut');
                return redirect()->route('home');
            }

            // Ambil jadwal staff untuk stasiun ini dan tanggal kedatangan flight
            $schedules = Schedule::where('date', $arrivalDate)
                ->whereIn('shift_id', $activeShifts->pluck('id'))
                ->get();

            $assigned = 0;
            $assignedSchedules = [];

            foreach ($schedules as $schedule) {
                if ($assigned >= $requiredPeople) break;

                $user = User::find($schedule->user_id);
                if (!$user) continue;

                // Validasi agar hanya assign staff yang berada di stasiun yang sama dengan flight
                if ($user->station !== $userStation) continue;

                if (str_starts_with($flightNumber, 'QF') && !$user->is_qantas) continue;

                Flight_details::create([
                    'flight_id' => $flight->id,
                    'schedule_id' => $schedule->id,
                ]);

                $assignedSchedules[] = $schedule;
                $assigned++;
            }

            $botToken = env('TELEGRAM_BOT_TOKEN');
            $chatIds = ['2050877699', '1631339759'];

            $assignedUsers = [];
            foreach ($assignedSchedules as $schedule) {
                $user = User::find($schedule->user_id);
                if ($user) {
                    array_push($assignedUsers, $user->fullname);
                }
            }

            $message = "✈️ Flight baru berhasil dibuat, Mohon untuk di lakukan pengerjaan:\n\n"
                . "Airline: {$flight->airline}\n"
                . "Flight Number: {$flight->flight_number}\n"
                . "Registrasi: {$flight->registasi}\n"
                . "Type: {$flight->type}\n"
                . "Arrival: {$flight->arrival}\n"
                . "Tanggal: {$arrivalDate}\n"
                . "Assigned: " . implode(', ', $assignedUsers) . " ({$assigned}/{$requiredPeople})";

            foreach ($chatIds as $chatId) {
                try {
                    Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                        'chat_id' => $chatId,
                        'text' => $message
                    ]);
                } catch (\Exception $e) {
                    Log::error("Gagal kirim Telegram ke {$chatId}: " . $e->getMessage());
                }
            }

            Alert::success('Berhasil', 'Data berhasil dibuat');
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data flight: ' . $e->getMessage());
            Alert::error('Terjadi Kesalahan', 'Gagal menyimpan data flight: ' . $e->getMessage());
            return redirect()->route('home');
        }
    }


    public function update(Flights $flight)
    {
        try {
            $flight->update(['status' => true]);
            Alert::success('Berhasil', 'Status berhasil di update');
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Error saat mengupdate status: ' . $e->getMessage());
            Alert::error('Terjadi Kesalahan', 'Gagal mengupdate status.');
            return redirect()->route('home');
        }
    }

    public function getDetails($id)
    {
        $flight = Flights::with('details')->findOrFail(id: $id);

        return response()->json([
            'flight' => $flight,
            'details' => $flight->details,
        ]);
    }
}
