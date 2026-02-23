<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Station;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

// LIBRARY EXCEL (Wajib ada)
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StaffExport;
use App\Imports\StaffImport;

class StaffController extends Controller
{
    // =================================================================
    // 1. MONITORING STAFF (INDEX)
    // =================================================================
    public function index(Request $request)
    {
        $search = $request->search;

        // 1. Ambil daftar station aktif
        $stations = Station::where('is_active', 1)
            ->orderBy('code', 'ASC')
            ->get();

        // 2. Base query
        $query = User::query();

        // 3. Filter search (NIP / Nama)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // 4. Filter station dari tab
        if ($request->filled('station')) {
            $query->where('station', $request->station);
        }

        // 5. Jika bukan Admin, paksa station sendiri
        if (Auth::user()->role !== 'Admin') {
            $query->where('station', Auth::user()->station);
        }

        // 6. Ambil data + pagination
        $staffs = $query->orderBy('fullname', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('staff.index', compact('staffs', 'stations'));
    }

    // =================================================================
    // 2. EXPORT DATA KE CSV
    // =================================================================
    public function export(Request $request)
    {
        // Cek Keamanan
        if (Auth::user()->role !== 'Admin') {
            abort(403);
        }

        $station = $request->station ?? null;
        $fileName = 'staff_data_' . ($station ? $station : 'global') . '_' . date('Y-m-d') . '.csv';

        return Excel::download(new StaffExport($station), $fileName);
    }

    // =================================================================
    // 3. IMPORT DATA DARI CSV
    // =================================================================
    public function import(Request $request)
    {
        // Cek Keamanan
        if (Auth::user()->role !== 'Admin') {
            abort(403);
        }

        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx'
        ]);

        try {
            // Proses Import menggunakan Class StaffImport
            Excel::import(new StaffImport, $request->file('file'));

            Alert::success('Berhasil', 'Data Staff berhasil diimpor!');
        } catch (\Exception $e) {
            // Tangkap error jika format CSV salah atau ID duplikat
            Alert::error('Gagal', 'Gagal impor: ' . $e->getMessage());
        }

        return back();
    }

    // =================================================================
    // 4. DOWNLOAD TEMPLATE CSV (Agar format upload benar)
    // =================================================================
    public function template()
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403);
        }

        // Header CSV yang dibutuhkan
        $headers = [
            'id_nip',
            'nama_lengkap',
            'email',
            'role',
            'station_code',
            'gender',
            'tanggal_gabung',
            'gaji',
            'mulai_kontrak',
            'selesai_kontrak',
            'no_pas',
            'pas_expired'
        ];

        // Buat file CSV on-the-fly (langsung download)
        $callback = function () use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers); // Tulis Header

            // Contoh Data Dummy
            fputcsv($file, [
                '12345',
                'Budi Santoso',
                'budi@aps.com',
                'Porter Apron',
                'CGK',
                'Male',
                '2023-01-01',
                '5000000',
                '2023-01-01',
                '2024-01-01',
                'PAS-001',
                '2024-05-20'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=template_upload_staff.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ]);
    }
    // =================================================================
    // 5. FITUR ON/OFF STAFF (MANPOWER CONTROL)
    // =================================================================
    public function toggleStatus($id)
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403);
        }

        // Mencegah Admin menonaktifkan dirinya sendiri
        if ($id == Auth::user()->id) {
            Alert::error('Error', 'Anda tidak bisa menonaktifkan akun sendiri!');
            return back();
        }

        $user = User::findOrFail($id);

        // Balik statusnya (1 jadi 0, 0 jadi 1)
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'DIAKTIFKAN' : 'DINONAKTIFKAN';
        Alert::success('Berhasil', "Staff {$user->fullname} berhasil {$status}.");

        return back();
    }
}
