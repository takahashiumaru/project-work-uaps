<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceReportExport;
use App\Models\Attendance;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'type' => 'required|in:in,out',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $now = Carbon::now();
        $today = $now->format('Y-m-d');

        /*
    |--------------------------------------------------------------------------
    | 1️⃣ VALIDASI GEOFENCING
    |--------------------------------------------------------------------------
    */

        $userStation = strtoupper(trim($user->station));
        $stationsConfig = config('locations.stations');

        if (!array_key_exists($userStation, $stationsConfig)) {
            return back()->with('error', 'Station belum diatur di config.');
        }

        $target = $stationsConfig[$userStation];

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $target['latitude'],
            $target['longitude']
        );

        $allowedRadius = config('locations.radius', 20);

        if ($distance > $allowedRadius) {
            return back()->with(
                'error',
                "Anda berada di luar radius {$target['name']}. Jarak: "
                    . round($distance) . " meter (Max {$allowedRadius}m)"
            );
        }

        /*
    |--------------------------------------------------------------------------
    | 2️⃣ SIMPAN FOTO
    |--------------------------------------------------------------------------
    */

        $photoData = str_replace('data:image/png;base64,', '', $request->photo);
        $photoData = str_replace(' ', '+', $photoData);

        $fileName = 'attendance_' . $user->id . '_' . time() . '.png';

        Storage::disk('public')->put(
            'attendance/' . $fileName,
            base64_decode($photoData)
        );

        /*
    |--------------------------------------------------------------------------
    | 3️⃣ CHECK IN / CHECK OUT
    |--------------------------------------------------------------------------
    */

        if ($request->type === 'in') {

            $existing = Attendance::where('user_id', $user->id)
                ->whereDate('check_in_time', $today)
                ->first();

            if ($existing) {
                return back()->with('error', 'Anda sudah check-in hari ini.');
            }

            Attendance::create([
                'user_id' => $user->id,
                'check_in_time' => $now,
                'check_in_photo' => $fileName,
                'check_in_latitude' => $request->latitude,
                'check_in_longitude' => $request->longitude,
            ]);
        } else {

            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('check_in_time', $today)
                ->first();

            if (!$attendance) {
                return back()->with('error', 'Belum check-in hari ini.');
            }

            if ($attendance->check_out_time) {
                return back()->with('error', 'Anda sudah check-out hari ini.');
            }

            $attendance->update([
                'check_out_time' => $now,
                'check_out_photo' => $fileName,
            ]);
        }

        return redirect()->route('attendance.index')
            ->with('success', 'Absensi berhasil!');
    }

    // =========================================================================
    // BAGIAN INI YANG SAYA PERBAIKI AGAR GPS AKURAT & SESUAI STATION USER
    // =========================================================================
    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $now = Carbon::now();
        $today = $now->format('Y-m-d');

        // 1. Cek apakah sudah absen hari ini
        $existingCheckIn = Attendance::where('user_id', $user->id)
            ->whereDate('check_in_time', $today)
            ->first();

        if ($existingCheckIn) {
            return response()->json(['success' => false, 'message' => 'Anda sudah melakukan Check-in hari ini.']);
        }

        // 2. Ambil Nama Station User & Jadikan HURUF BESAR (UPPERCASE)
        // Agar cocok dengan config (contoh: "Cgk" -> "CGK")
        $userStation = strtoupper(trim($user->station));

        // 3. Ambil Konfigurasi Lokasi
        $stationsConfig = config('locations.stations');

        // Cek apakah station user terdaftar di Config
        if (!array_key_exists($userStation, $stationsConfig)) {
            return response()->json([
                'success' => false,
                'message' => "Lokasi untuk station '{$user->station}' belum diatur di sistem (Config)."
            ]);
        }

        // Ambil Koordinat Target (Kantor)
        $targetLocation = $stationsConfig[$userStation];
        $targetLat = $targetLocation['latitude'];
        $targetLon = $targetLocation['longitude'];
        $locationName = $targetLocation['name'] ?? $userStation;

        // 4. Hitung Jarak (GPS HP User vs GPS Kantor)
        $userLat = $request->latitude;
        $userLon = $request->longitude;

        $distance = $this->calculateDistance($userLat, $userLon, $targetLat, $targetLon);

        // Ambil radius toleransi dari config (Default 20 meter jika tidak diatur)
        $allowedRadius = config('locations.radius', 20);

        // 5. Validasi Radius (Geofencing)
        if ($distance > $allowedRadius) {
            return response()->json([
                'success' => false,
                'message' => "Absensi Gagal! Anda berada di luar radius {$locationName}. Jarak: " . round($distance) . " meter (Maks: {$allowedRadius}m).",
            ]);
        }

        // 6. Cek Jadwal Shift
        $schedule = Schedule::with('shift')
            ->where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$schedule || !$schedule->shift) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki jadwal shift untuk hari ini.']);
        }

        $shiftStartTime = Carbon::parse($schedule->date . ' ' . $schedule->shift->start_time);
        $status = ($now->isAfter($shiftStartTime)) ? 'Terlambat' : 'Tepat Waktu';

        // 7. Simpan Data Absensi dengan Koordinat
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
                'message' => "Check-in berhasil di {$locationName}! Status: {$status}.",
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan data ke database.']);
        }
    }

    /**
     * @return float
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius Bumi (Meter)

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    // =========================================================================
    // FUNGSI DI BAWAH INI TIDAK SAYA UBAH (SAMA SEPERTI ASLINYA)
    // =========================================================================

    public function history(Request $request)
    {
        $user = Auth::user();

        // Ambil bulan dari request, default bulan ini (format YYYY-MM)
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        $startDate = Carbon::parse($month)->startOfMonth();
        $endDate = Carbon::parse($month)->endOfMonth();

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
                'schedule' => $schedule,
                'attendance' => $attendance,
            ];
        }

        return view('attendance.history', compact('daysInMonth', 'month', 'user'));
    }

    public function reportsIndex(Request $request)
    {
        $attendances = collect();
        $message = null;

        if ($request->filled('month')) {
            // try {
            $period = Carbon::createFromFormat('Y-m', $request->month);

            $startDate = $period->copy()->startOfMonth();
            $endDate = $period->copy()->endOfMonth();
            try {
                $monthInput = substr($request->month, 0, 7); // ambil YYYY-MM
                $period = \Carbon\Carbon::parse($monthInput . '-01'); // pakai parse, bukan createFromFormat
                $startDate = $period->copy()->startOfMonth();
                $endDate = $period->copy()->endOfMonth();
            } catch (\Exception $e) {
                $message = "Format periode tidak valid. (value: {$request->month})";
            }

            // Cari user by NIP atau nama
            $user = \App\Models\User::where('id', $request->user_name)
                ->orWhere('fullname', 'LIKE', "%{$request->user_name}%")
                ->first();

            if (! $user) {
                $message = 'Karyawan tidak ditemukan.';
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
                        $attendances->push((object) [
                            'date' => $dateStr,
                            'attendance' => $attendancesForDate->first(),
                            // 'schedule' => $schedule,
                            'user' => $user,
                        ]);
                    } else {
                        // Untuk tiap schedule di tanggal tersebut, buat row sendiri
                        foreach ($schedulesForDate as $schedule) {
                            // Jika mau mapping attendance ke schedule lebih presisi, boleh ditambahkan logika matching di sini.
                            $attendances->push([
                                'date' => $dateStr,
                                'attendance' => $attendancesForDate->first(), // tetap first() untuk saat ini
                                // 'schedule' => $schedule,
                                'user' => $user,
                            ]);
                        }
                    }

                    $cursor->addDay();
                }
            }
            // } catch (\Exception $e) {
            //    // opsional: log error -> \Log::error($e);
            //    $message = 'Format periode tidak valid.';
            // }
        }

        return view('attendance.report', compact('attendances', 'message'));
    }

    public function export(Request $request)
    {
        if (! $request->filled('month') || ! $request->filled('user_name')) {
            return redirect()->back()->with('error', 'Pilih periode dan karyawan terlebih dahulu.');
        }

        // Sama persis dengan method reportsIndex
        $period = \Carbon\Carbon::createFromFormat('Y-m', $request->month);
        $startDate = $period->copy()->startOfMonth();
        $endDate = $period->copy()->endOfMonth();

        $user = \App\Models\User::where('id', $request->user_name)
            ->orWhere('fullname', 'LIKE', "%{$request->user_name}%")
            ->first();

        if (! $user) {
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
                    'user' => $user,
                ]);
            } else {
                foreach ($schedulesForDate as $schedule) {
                    $attendances->push([
                        'date' => $dateStr,
                        'attendance' => $attendancesForDate->first(),
                        'schedule' => $schedule,
                        'user' => $user,
                    ]);
                }
            }
            $cursor->addDay();
        }

        $fileName = 'Laporan_Absensi_' . $user->fullname . '_' . $request->month . '.xlsx';

        return Excel::download(new AttendanceReportExport($attendances), $fileName);
    }
}
