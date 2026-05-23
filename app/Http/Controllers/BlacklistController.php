<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blacklist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $blacklists = $query->latest()->paginate(10)->withQueryString();
        return view('blacklist.index', compact('blacklists'));
    }

    // PROSES BAN USER (DARI HALAMAN USER)
    public function store(Request $request)
    {
        if (strtoupper((string) Auth::user()->role) !== 'ADMIN') {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'reason'  => 'required|string|min:5'
        ]);

        $user = User::findOrFail($request->user_id);
        $blacklistKey = trim((string) ($user->no_nik ?: $user->id));

        if ($blacklistKey === '') {
            Alert::error('Gagal', 'NIK/NIP staff tidak ditemukan, blacklist tidak dapat diproses.');
            return back();
        }

        $alreadyBlacklisted = Blacklist::where('nik', $blacklistKey)->first();

        if ($alreadyBlacklisted) {
            $user->forceFill(['is_active' => 0])->save();
            Alert::warning('Sudah Blacklist', "{$user->fullname} sudah ada di daftar blacklist dan akun sudah dinonaktifkan.");
            return back();
        }

        DB::transaction(function () use ($user, $request, $blacklistKey) {
            // 1. Simpan ke Tabel Blacklist. Jika NIK kosong, gunakan NIP/user id.
            Blacklist::create([
                'nik'       => $blacklistKey,
                'fullname'  => $user->fullname,
                'reason'    => trim($request->reason),
                'station'   => $user->station ?: '-',
                'banned_by' => Auth::user()->fullname
            ]);

            // 2. Nonaktifkan Akun User (Kill Switch)
            $user->forceFill(['is_active' => 0])->save();
        });

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
