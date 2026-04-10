<?php

namespace App\Http\Controllers;

use App\Models\Flights; // Pastikan model ini benar
use App\Models\User;
use App\Models\Leave;
use App\Models\Station; // Tambahkan Model Station
use Illuminate\Http\Request; // Wajib import Request untuk menangkap input filter
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Menampilkan data dashboard utama dengan Filter Station.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        // =================================================================
        // BAGIAN 0: LOGIKA FILTER STATION (BARU)
        // =================================================================
        
        // Default: Station milik user yang login
        $selectedStation = $user->station; 

        // Jika Admin, boleh ambil dari Dropdown (Request). Jika kosong, default 'All'
        if ($user->role == 'Admin') {
            $selectedStation = $request->input('station', 'All');
        }

        // Siapkan list station untuk isi Dropdown (Khusus Admin)
        $listStations = [];
        if ($user->role == 'Admin') {
            $listStations = Station::where('is_active', 1)->get();
        }

        // =================================================================
        // BAGIAN 1: MENGAMBIL DATA UTAMA (DENGAN FILTER)
        // =================================================================
        
        // 1. Data Penerbangan Hari Ini
        $flightsQuery = Flights::whereDate('created_at', Carbon::today());
        if ($selectedStation !== 'All') {
            $flightsQuery->where('station', $selectedStation);
        }
        $flights = $flightsQuery->get();

        // 2. Total Penerbangan Selesai Hari Ini
        $totalFlightQuery = Flights::where('status', true)->whereDate('created_at', Carbon::today());
        if ($selectedStation !== 'All') {
            $totalFlightQuery->where('station', $selectedStation);
        }
        $totalFlightPerDay = $totalFlightQuery->count();


        // 3. Total Staff (User Count)
        $userQuery = User::query();
        if ($selectedStation !== 'All') {
            $userQuery->where('station', $selectedStation);
        }
        $userCount = $userQuery->count();
        $userKehadiranCount = $userCount; // Disamakan agar persentase akurat per station


        // 4. Staff Sedang Bekerja (Working Manpower via Flight Details)
        $workingQuery = DB::table('flight_details')
            ->join('flights', 'flight_details.flight_id', '=', 'flights.id')
            ->where('flights.status', 0)
            ->whereDate('flights.created_at', Carbon::today());
            
        if ($selectedStation !== 'All') {
            $workingQuery->where('flights.station', $selectedStation);
        }
        $workingManpowers = $workingQuery->count();


        // =================================================================
        // BAGIAN 2: MENYIAPKAN DATA UNTUK INFO CARD
        // =================================================================
        $twoMonthsFromNow = Carbon::today()->addMonths(2);

        // 1. Kontrak Expired Soon
        $contractQuery = User::whereDate('contract_end', '<=', $twoMonthsFromNow)
            ->whereDate('contract_end', '>=', Carbon::today());
        if ($selectedStation !== 'All') {
            $contractQuery->where('station', $selectedStation);
        }
        $totalContractStaff = $contractQuery->count();


        // 2. PAS Expired Soon
        $pasQuery = User::whereDate('pas_expired', '<=', $twoMonthsFromNow)
            ->whereDate('pas_expired', '>=', Carbon::today());
        if ($selectedStation !== 'All') {
            $pasQuery->where('station', $selectedStation);
        }
        $totalPasStaff = $pasQuery->count();


        // 3. Data Absensi / Cuti Hari Ini
        $absentQuery = DB::table('leaves')
            ->join('users', 'leaves.user_id', '=', 'users.id')
            ->whereDate('leaves.start_date', '<=', Carbon::today())
            ->whereDate('leaves.end_date', '>=', Carbon::today())
            ->where('leaves.status', 'approved');
            
        if ($selectedStation !== 'All') {
            $absentQuery->where('users.station', $selectedStation);
        }
        
        $absentUsers = $absentQuery->select('users.id', 'users.fullname', 'leaves.leave_type', 'leaves.status')->get();
        $totalAbsent = $absentUsers->count();

        // Hitung Hadir & Persentase
        $presentToday = $userKehadiranCount - $totalAbsent;
        $attendancePercentage = $userKehadiranCount > 0
            ? round(($presentToday / $userKehadiranCount) * 100, 2)
            : 0;

        // =================================================================
        // BAGIAN 3: CHART (DENGAN FILTER STATION)
        // =================================================================
        $lineChartLabels = [];
        $lineChartData = [];
        $barChartLabels = [];
        $sickData = [];
        $leaveData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $dayName = $date->locale('id')->dayName;

            $lineChartLabels[] = $dayName;
            $barChartLabels[] = $dayName;

            // Line Chart: Total Penerbangan per hari (Filtered)
            $dailyFlightQ = Flights::whereDate('created_at', $dateString);
            if ($selectedStation !== 'All') { $dailyFlightQ->where('station', $selectedStation); }
            $lineChartData[] = $dailyFlightQ->count();

            // Bar Chart: Sakit (Filtered by User Station via Join)
            $sickQ = Leave::join('users', 'leaves.user_id', '=', 'users.id')
                    ->whereDate('leaves.start_date', $dateString)
                    ->where('leaves.leave_type', 'Cuti Sakit');
            if ($selectedStation !== 'All') { $sickQ->where('users.station', $selectedStation); }
            $sickData[] = $sickQ->count();

            // Bar Chart: Cuti (Filtered by User Station via Join)
            $leaveQ = Leave::join('users', 'leaves.user_id', '=', 'users.id')
                    ->whereDate('leaves.start_date', $dateString)
                    ->where('leaves.leave_type', 'Cuti Tahunan');
            if ($selectedStation !== 'All') { $leaveQ->where('users.station', $selectedStation); }
            $leaveData[] = $leaveQ->count();
        }

        // Doughnut Chart: Distribusi Role (Filtered)
        $doughnutQuery = User::select('role', DB::raw('count(*) as total'));
        if ($selectedStation !== 'All') {
            $doughnutQuery->where('station', $selectedStation);
        }
        $doughnutData = $doughnutQuery->groupBy('role')->get();

        $doughnutChartLabels = $doughnutData->pluck('role');
        $doughnutChartData = $doughnutData->pluck('total');


        // =================================================================
        // BAGIAN 4: SWEETALERT & MONITORING
        // =================================================================
        if ($user) {
            if (empty($user->pas_expired)) {
                Alert::warning('Peringatan', '⚠️ Belum ada data masa berlaku PAS Anda. Harap isi segera.');
            } else {
                $expiredDate = Carbon::parse($user->pas_expired);
                $today = Carbon::today();
                $diffMonths = ceil($today->diffInDays($expiredDate) / 30);

                if ($diffMonths <= 2 && $expiredDate->greaterThanOrEqualTo($today)) {
                    Alert::warning('Peringatan', '⚠️ Masa berlaku PAS Anda akan habis dalam ' . $diffMonths . ' bulan lagi. Harap segera perpanjang.');
                }
            }
        }

        // Data Monitoring Station (Untuk Widget Kartu-Kartu Station)
        // Kita tampilkan semua station di widget bawah, tapi Dashboard utama mengikuti filter dropdown
        $allStations = Station::where('is_active', 1)->get();
        $stationStats = User::select('station', DB::raw('count(*) as total'))
            ->groupBy('station')
            ->pluck('total', 'station');


        // =================================================================
        // BAGIAN 5: RETURN VIEW
        // =================================================================
        return view('home', compact(
            // Data Filter
            'selectedStation',
            'listStations',

            // KPI Utama
            'userCount',
            'workingManpowers',
            'flights',
            'totalFlightPerDay',

            // Info Card
            'totalContractStaff',
            'totalPasStaff',
            'totalAbsent',
            'attendancePercentage',
            'presentToday',

            // Charts
            'lineChartLabels',
            'lineChartData',
            'doughnutChartLabels',
            'doughnutChartData',
            'barChartLabels',
            'sickData',
            'leaveData',

            // Monitoring Station Widget
            'allStations',
            'stationStats'
        ));
    }

    /**
     * Method Generate PDF (TIDAK DIUBAH)
     */
    public function generatePDF()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }

        $karyawan = DB::table('users')
            ->select('id', 'fullname', 'role', 'alamat')
            ->where('id', $user->id)
            ->first();

        if (!$karyawan) {
            return back()->withErrors('Data karyawan tidak ditemukan.');
        }

        $tanggal_surat = now()->translatedFormat('d F Y');
        $logoPath = public_path('storage/photo/JAS Airport Services.png');
        
        // Cek jika file ada untuk menghindari error
        $base64Logo = '';
        if (file_exists($logoPath)) {
            $base64Logo = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $pdf = Pdf::loadView('template', [
            'nama_karyawan' => $karyawan->fullname,
            'nik_karyawan' => $karyawan->id,
            'posisi_karyawan' => $karyawan->role,
            'alamat_karyawan' => $karyawan->alamat,
            'tanggal_surat' => $tanggal_surat,
            'base64' => $base64Logo,
        ]);

        return $pdf->download("Surat-Pengganti-ID-Card-{$karyawan->fullname}.pdf");
    }

    public function Document(): View
    {
        return view('document');
    }
}