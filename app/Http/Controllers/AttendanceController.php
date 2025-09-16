<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\AttendanceReportExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();


        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('check_in_time', $today)
            ->first();


        $todaySchedule = Schedule::with('shift')
            ->where('user_id', $user->id)
            ->where('date', $today->toDateString())
            ->first();

        return view('attendance.index', compact('todayAttendance', 'todaySchedule', 'user'));
    }

    // AttendanceController.php
    public function camera(Request $request)
    {
        $type = $request->query('type', 'in'); // in / out
        return view('attendance.camera', compact('type'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'photo' => 'required|string',
            'type'  => 'required|in:in,out',
        ]);

        $user = Auth::user();

        // Simpan foto base64 jadi file
        $photoData = $request->photo;
        $photoData = str_replace('data:image/png;base64,', '', $photoData);
        $photoData = str_replace(' ', '+', $photoData);
        $fileName  = 'attendance_' . $user->id . '_' . time() . '.png';
        Storage::disk('public')->put('attendance/' . $fileName, base64_decode($photoData));

        // Simpan ke database
        if ($request->type === 'in') {
            Attendance::create([
                'user_id' => $user->id,
                'check_in_time' => now(),
                'check_in_photo' => $fileName,
            ]);
        } else {
            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('check_in_time', today())
                ->first();

            if ($attendance) {
                $attendance->update([
                    'check_out_time' => now(),
                    'check_out_photo' => $fileName,
                ]);
            }
        }

        return redirect()->route('attendance.index')->with('success', 'Absensi berhasil!');
    }


    public function checkIn(Request $request)
    {

        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();


        $existingCheckIn = Attendance::where('user_id', $user->id)
            ->whereDate('check_in_time', $today)
            ->first();

        if ($existingCheckIn) {
            return response()->json(['success' => false, 'message' => 'Anda sudah melakukan Check-in hari ini.']);
        }

        $schedule = Schedule::with('shift')
            ->where('user_id', $user->id)
            ->where('date', $today->toDateString())
            ->first();

        if (!$schedule || !$schedule->shift) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki jadwal shift untuk hari ini.']);
        }


        $stationName = $user->station;
        $targetLocation = config("locations.stations.{$stationName}");

        if (!$targetLocation) {
            return response()->json(['success' => false, 'message' => "Lokasi untuk stasiun '{$stationName}' tidak ditemukan dalam konfigurasi."]);
        }

        $userLat = $request->latitude;
        $userLon = $request->longitude;
        $targetLat = $targetLocation['latitude'];
        $targetLon = $targetLocation['longitude'];

        $distance = $this->calculateDistance($userLat, $userLon, $targetLat, $targetLon);
        $allowedRadius = config('locations.radius');

        if ($distance > $allowedRadius) {
            return response()->json([
                'success' => false,
                'message' => "Absensi Gagal. Anda berada " . round($distance) . " meter dari lokasi yang ditentukan ({$allowedRadius} meter).",
            ]);
        }


        $shiftStartTime = Carbon::parse($schedule->date . ' ' . $schedule->shift->start_time);

        $status = ($now->isAfter($shiftStartTime)) ? 'Terlambat' : 'Tepat Waktu';


        try {
            Attendance::create([
                'user_id' => $user->id,
                'check_in_time' => $now,
                'check_in_ip' => $request->ip(),
                'check_in_latitude' => $userLat,
                'check_in_longitude' => $userLon,
                'status' => $status,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Check-in berhasil! Status: {$status}."
            ]);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data. Pastikan kolom "status" ada di tabel attendances.']);
        }
    }

    /**

     * @return float
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    public function history(Request $request)
    {
        $user = Auth::user();

        // Ambil bulan dari request, default bulan ini (format YYYY-MM)
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        $startDate = Carbon::parse($month)->startOfMonth();
        $endDate   = Carbon::parse($month)->endOfMonth();

        // Ambil semua schedule user beserta data shift untuk sebulan
        $scheduleData = Schedule::where('user_id', $user->id)
            ->join('shifts', 'shifts.id', '=', 'schedules.shift_id')
            ->selectRaw('schedules.*, shifts.description as shift_description, shifts.start_time, shifts.end_time')
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->date)->toDateString()); // keyBy tanggal YYYY-MM-DD

        // Ambil semua absensi user untuk sebulan
        $attendanceData = Attendance::where('user_id', $user->id)
            ->whereBetween('check_in_time', [$startDate->toDateString() . ' 00:00:00', $endDate->toDateString() . ' 23:59:59'])
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->check_in_time)->toDateString()); // keyBy tanggal YYYY-MM-DD

        // Siapkan data per hari untuk Blade
        $daysInMonth = [];
        for ($day = 1; $day <= $startDate->daysInMonth; $day++) {
            $dateString = $startDate->copy()->day($day)->toDateString();

            $schedule = $scheduleData[$dateString] ?? null;   // Aman, tidak ada undefined key
            $attendance = $attendanceData[$dateString] ?? null;

            $daysInMonth[$day] = [
                'schedule'   => $schedule,
                'attendance' => $attendance,
            ];
        }

        return view('attendance.history', compact('daysInMonth', 'month', 'user'));
    }

    public function reportsIndex(Request $request)
    {
        $attendances = collect();
        $message = null;

        if ($request->filled('month') && $request->filled('user_name')) {
            try {
                $period = Carbon::createFromFormat('Y-m', $request->month);
                $startDate = $period->copy()->startOfMonth();
                $endDate   = $period->copy()->endOfMonth();

                // Cari user by NIP atau nama
                $user = \App\Models\User::where('id', $request->user_name)
                    ->orWhere('fullname', 'LIKE', "%{$request->user_name}%")
                    ->first();

                if (!$user) {
                    $message = "Karyawan tidak ditemukan.";
                } else {
                    // Ambil semua attendance untuk bulan itu, group by tanggal
                    $attData = \App\Models\Attendance::where('user_id', $user->id)
                        ->whereBetween('check_in_time', [$startDate->startOfDay(), $endDate->endOfDay()])
                        ->get()
                        ->groupBy(fn($att) => Carbon::parse($att->check_in_time)->toDateString());

                    // Ambil semua schedule untuk bulan itu, group by tanggal
                    $scheduleData = \App\Models\Schedule::where('user_id', $user->id)
                        ->selectRaw('schedules.*, shifts.description as shift_description, shifts.start_time, shifts.end_time')
                        ->join('shifts', 'shifts.id', '=', 'schedules.shift_id')
                        ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
                        ->get()
                        ->groupBy(fn($item) => Carbon::parse($item->date)->toDateString());

                    // Generate rows: satu row per schedule. Jika tidak ada schedule => satu row "libur"
                    $cursor = $startDate->copy();
                    while ($cursor->lte($endDate)) {
                        $dateStr = $cursor->toDateString();

                        $attendancesForDate = $attData->get($dateStr) ?? collect();
                        $schedulesForDate = $scheduleData->get($dateStr) ?? collect();

                        if ($schedulesForDate->isEmpty()) {
                            // Tidak ada schedule = libur (tetap satu row, bisa ada attendance meskipun tidak terjadwal)
                            $attendances->push([
                                'date' => $dateStr,
                                'attendance' => $attendancesForDate->first(), // bisa null
                                'schedule' => null,
                                'user' => $user
                            ]);
                        } else {
                            // Untuk tiap schedule di tanggal tersebut, buat row sendiri
                            foreach ($schedulesForDate as $schedule) {
                                // Jika mau mapping attendance ke schedule lebih presisi, boleh ditambahkan logika matching di sini.
                                $attendances->push([
                                    'date' => $dateStr,
                                    'attendance' => $attendancesForDate->first(), // tetap first() untuk saat ini
                                    'schedule' => $schedule,
                                    'user' => $user
                                ]);
                            }
                        }

                        $cursor->addDay();
                    }
                }
            } catch (\Exception $e) {
                // opsional: log error -> \Log::error($e);
                $message = "Format periode tidak valid.";
            }
        }

        return view('attendance.report', compact('attendances', 'message'));
    }

    public function export(Request $request)
    {
        if (!$request->filled('month') || !$request->filled('user_name')) {
            return redirect()->back()->with('error', 'Pilih periode dan karyawan terlebih dahulu.');
        }

        // Sama persis dengan method reportsIndex
        $period = \Carbon\Carbon::createFromFormat('Y-m', $request->month);
        $startDate = $period->copy()->startOfMonth();
        $endDate   = $period->copy()->endOfMonth();

        $user = \App\Models\User::where('id', $request->user_name)
            ->orWhere('fullname', 'LIKE', "%{$request->user_name}%")
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan.');
        }

        // Ambil attendance & schedule
        $attData = \App\Models\Attendance::where('user_id', $user->id)
            ->whereBetween('check_in_time', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->get()
            ->groupBy(fn($att) => \Carbon\Carbon::parse($att->check_in_time)->toDateString());

        $scheduleData = \App\Models\Schedule::where('user_id', $user->id)
            ->selectRaw('schedules.*, shifts.description as shift_description, shifts.start_time, shifts.end_time')
            ->join('shifts', 'shifts.id', '=', 'schedules.shift_id')
            ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
            ->get()
            ->groupBy(fn($item) => \Carbon\Carbon::parse($item->date)->toDateString());

        // Generate rows
        $attendances = collect();
        $cursor = $startDate->copy();
        while ($cursor->lte($endDate)) {
            $dateStr = $cursor->toDateString();
            $attendancesForDate = $attData->get($dateStr) ?? collect();
            $schedulesForDate = $scheduleData->get($dateStr) ?? collect();

            if ($schedulesForDate->isEmpty()) {
                $attendances->push([
                    'date' => $dateStr,
                    'attendance' => $attendancesForDate->first(),
                    'schedule' => null,
                    'user' => $user
                ]);
            } else {
                foreach ($schedulesForDate as $schedule) {
                    $attendances->push([
                        'date' => $dateStr,
                        'attendance' => $attendancesForDate->first(),
                        'schedule' => $schedule,
                        'user' => $user
                    ]);
                }
            }
            $cursor->addDay();
        }

        $fileName = 'Laporan_Absensi_' . $user->fullname . '_' . $request->month . '.xlsx';

        return Excel::download(new AttendanceReportExport($attendances), $fileName);
    }
}
