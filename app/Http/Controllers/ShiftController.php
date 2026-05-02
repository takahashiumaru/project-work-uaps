<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class ShiftController extends Controller
{
    public function index(): View
    {
        if (! in_array(Auth::user()->role, ['Admin', 'Ass Leader', 'Chief', 'Leader'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        $perPage = request()->input('per_page', 30);
        $shifts = Shift::orderBy('id', 'asc')->paginate($perPage)->withQueryString();

        return view('shift.index', compact('shifts'));
    }

    public function create(): View
    {
        if (! in_array(Auth::user()->role, ['Admin', 'Ass Leader', 'Chief', 'Leader'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('shift.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'use_manpower' => 'required',
        ]);

        try {
            Shift::create($request->only([
                'id',
                'name',
                'description',
                'start_time',
                'end_time',
                'use_manpower',
            ]));

            Alert::success('Success', 'Data berhasil disimpan');

            return redirect()->route('shift.index');
        } catch (\Exception $e) {
            Log::error('Error saat create data: '.$e->getMessage());
            Alert::error('Terjadi Kesalahan', 'Gagal create data.');

            return back()->withInput();
        }
    }

    public function edit(Shift $shift): View
    {
        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('shift.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        Log::info('Request masuk ke update()', ['data' => $request->all()]);

        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'use_manpower' => 'required',
        ]);

        try {
            $shift->update($request->only([
                'id',
                'name',
                'description',
                'start_time',
                'end_time',
                'use_manpower',
            ]));

            Alert::success('Success', 'Data shift berhasil diperbarui');

            return redirect()->route('shift.index');
        } catch (\Exception $e) {
            Log::error('Gagal update shift: '.$e->getMessage(), [
                'request' => $request->all(),
                'shift_id' => $shift->id,
            ]);

            Alert::error('Terjadi Kesalahan', 'Gagal memperbarui data shift.');

            return back()->withInput();
        }
    }

    public function destroy(Shift $shift)
    {
        if (! in_array(Auth::user()->role, ['Admin', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        try {
            // Cek apakah shift digunakan di tabel schedules
            $isUsed = \App\Models\Schedule::where('shift_id', $shift->id)->exists();
            if ($isUsed) {
                Alert::error('Gagal', 'Shift ini tidak bisa dihapus karena sedang digunakan dalam jadwal kerja.');

                return back();
            }

            $shift->delete();
            Alert::success('Berhasil', 'Data shift berhasil dihapus');

            return redirect()->route('shift.index');
        } catch (\Exception $e) {
            Log::error('Gagal hapus shift: '.$e->getMessage());
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data: '.$e->getMessage());

            return back();
        }
    }
}
