<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blacklist;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BlacklistController extends Controller
{
    // Tampilkan Daftar Blacklist
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $query = Blacklist::query();

        if ($request->has('search')) {
            $query->where('fullname', 'like', '%'.$request->search.'%')
                  ->orWhere('nik', 'like', '%'.$request->search.'%');
        }

        $blacklists = $query->latest()->paginate(10);
        return view('blacklist.index', compact('blacklists'));
    }

    // PROSES BAN USER (DARI HALAMAN USER)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason'  => 'required|string|min:5'
        ]);

        $user = User::findOrFail($request->user_id);

        // 1. Simpan ke Tabel Blacklist
        Blacklist::create([
            'nik'       => $user->no_nik, // Asumsi ID User adalah NIK/NIP
            'fullname'  => $user->fullname,
            'reason'    => $request->reason,
            'station'   => $user->station,
            'banned_by' => Auth::user()->fullname
        ]);

        // 2. Nonaktifkan Akun User (Kill Switch)
        $user->is_active = 0;
        $user->save();

        // Opsional: Hapus user permanen jika tidak ingin menuh-menuhin tabel users
        // $user->delete();

        Alert::success('Sanksi Tegas', 'Staff berhasil di-blacklist dan akun dinonaktifkan.');
        return back();
    }

    // Hapus dari Blacklist (Jika ternyata salah paham/banding diterima)
    public function destroy($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        Blacklist::destroy($id);
        Alert::success('Berhasil', 'Data dihapus dari daftar hitam.');
        return back();
    }
}
