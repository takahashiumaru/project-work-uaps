<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Flights;
use App\Models\schedule;
use App\Models\shift;
use App\Models\flight_details;
use App\Models\user;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class flightController extends Controller
{
    public function index(): View
    {
        $flights = flights::orderBy('arrival_time', 'asc')->paginate(30);

        return view('flight.index', compact('flights'));
    }

    public function store(Request $request)
    {
        try {
            $flight = new flights();
            $flight->airline = $request->airline;
            $flight->flight_number = $request->flight_number;
            $flight->registasi = $request->registasi;
            $flight->type = $request->type;
            $flight->arrival = $request->arrival;
            $flight->time_count = $request->time_count;
            $flight->status = 0;
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

            $now = Carbon::now();
            $today = $now->format('Y-m-d');
            $currentTime = $now->format('H:i:s');

            $activeShifts = shift::where('start_time', '<=', $currentTime)
                ->where('end_time', '>=', $currentTime)
                ->get();

            if ($activeShifts->isEmpty()) {
                Alert::error('Gagal', 'Tidak ada shift aktif saat ini');
                return redirect()->route('home');
            }

            $schedules = schedule::where('date', $today)
                ->whereIn('shift_id', $activeShifts->pluck('id'))
                ->get();

            $assigned = 0;

            foreach ($schedules as $schedule) {
                if ($assigned >= $requiredPeople) break;

                $user = user::find($schedule->user_id);
                if (!$user) continue;

                if (str_starts_with($flightNumber, 'QF') && !$user->is_qantas) continue;

                flight_details::create([
                    'flight_id' => $flight->id,
                    'schedule_id' => $schedule->id,
                ]);

                $assigned++;
            }

            $botToken = env('TELEGRAM_BOT_TOKEN');

            $chatIds = ['2050877699', '1631339759'];

            $assignedUsers = [];
            foreach ($schedules as $schedule) {
                if (count($assignedUsers) >= $requiredPeople) break;

                $user = user::find($schedule->user_id);
                if (!$user) continue;

                if (str_starts_with($flightNumber, 'QF') && !$user->is_qantas) continue;

                array_push($assignedUsers, $user->fullname);
            }

            $message = "✈️ Flight baru berhasil dibuat, Mohon untuk di lakukan pengerjaan:\n\n"
                . "Airline: {$flight->airline}\n"
                . "Flight Number: {$flight->flight_number}\n"
                . "Registrasi: {$flight->registasi}\n"
                . "Type: {$flight->type}\n"
                . "Arrival: {$flight->arrival}\n"
                . "Tanggal: {$today}\n"
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
            Alert::error('Terjadi Kesalahan', 'Gagal menyimpan data flight.');
            return redirect()->route('home');
        }
    }


    public function update(flights $flight)
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
