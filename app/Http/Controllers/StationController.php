<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Station;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth; // Tambahkan ini agar Auth::user() terbaca

class StationController extends Controller
{
    // =================================================================
    // 1. FITUR BUKA STATION BARU
    // =================================================================
    public function create()
    {
        return view('stations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:stations,code|max:3|alpha',
            'name' => 'required|string|max:255',
        ]);

        Station::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'is_active' => true
        ]);

        Alert::success('Berhasil', 'Station baru berhasil dibuka!');
        return redirect()->route('home');
    }

    // =================================================================
    // 2. FITUR MANAJEMEN STATION (INDEX & KILL SWITCH)
    // =================================================================

    // Menampilkan Daftar Station
    public function index()
    {
        // Pengecekan Admin
        if (Auth::user()->role !== 'Admin') { 
            abort(403, 'Akses Ditolak'); 
        }

        $stations = Station::all(); // Ambil semua termasuk yang mati
        return view('stations.index', compact('stations'));
    }

    // Proses Ganti Status ON/OFF
    public function toggleStatus($id)
    {
        // Pengecekan Admin
        if (Auth::user()->role !== 'Admin') { 
            abort(403, 'Akses Ditolak'); 
        }

        $station = Station::findOrFail($id);
        
        // Balik statusnya (Jika 1 jadi 0, Jika 0 jadi 1)
        $station->is_active = !$station->is_active;
        $station->save();

        // Pesan Notifikasi
        $statusText = $station->is_active ? 'DIAKTIFKAN' : 'DINONAKTIFKAN';
        
        Alert::success('Berhasil', "Station {$station->code} berhasil {$statusText}.");

        return back();
    }

} // <--- PENUTUP CLASS HARUS ADA DI SINI (PALING BAWAH)