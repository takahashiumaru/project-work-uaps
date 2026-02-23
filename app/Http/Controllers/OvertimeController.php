<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class OvertimeController extends Controller
{
    // ==========================================
    // 1. HALAMAN STAFF (Riwayat & Input)
    // ==========================================
    public function index()
    {
        // Staff melihat riwayat lemburnya sendiri
        $overtimes = Overtime::where('user_id', Auth::id())
                        ->orderBy('date', 'desc')
                        ->paginate(10);

        return view('overtime.index', compact('overtimes'));
    }

    public function create()
    {
        return view('overtime.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'duration' => 'required|numeric|min:1',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Overtime::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'duration' => $request->duration,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Pending', // Otomatis Pending
        ]);

        Alert::success('Terkirim', 'Pengajuan lembur berhasil dikirim ke Leader.');
        return redirect()->route('overtime.index');
    }

    // ==========================================
    // 2. HALAMAN LEADER (Approval)
    // ==========================================
    public function approvalList()
    {
        $user = Auth::user();

        // Security Check: Hanya Admin/Leader yg boleh masuk
        if (!in_array($user->role, ['Admin', 'LEADER', 'CHIEF', 'ASS LEADER'])) {
            abort(403);
        }

        $query = Overtime::with('user')->where('status', 'Pending');

        // Jika BUKAN Admin, hanya tampilkan request dari Station yang sama
        if ($user->role !== 'Admin') {
            $query->whereHas('user', function($q) use ($user) {
                $q->where('station', $user->station);
            });
        }

        $pendingOvertimes = $query->orderBy('date', 'desc')->get();

        return view('overtime.approval', compact('pendingOvertimes'));
    }

    public function approve($id)
    {
        $ot = Overtime::findOrFail($id);
        $ot->update([
            'status' => 'Approved',
            'approved_by' => Auth::user()->fullname
        ]);

        Alert::success('Approved', 'Lembur staff telah disetujui.');
        return back();
    }

    public function reject($id)
    {
        $ot = Overtime::findOrFail($id);
        $ot->update([
            'status' => 'Rejected',
            'approved_by' => Auth::user()->fullname
        ]);

        Alert::warning('Rejected', 'Pengajuan lembur ditolak.');
        return back();
    }

    // ==========================================
    // 3. HALAMAN REKAP (Admin/HO)
    // ==========================================
    public function report(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $query = Overtime::with('user')->where('status', 'Approved');

        // Filter Station
        if ($request->has('station') && $request->station != null) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('station', $request->station);
            });
        }
        
        // Filter Tanggal (Opsional)
        if ($request->date_start && $request->date_end) {
            $query->whereBetween('date', [$request->date_start, $request->date_end]);
        }

        $overtimes = $query->latest()->paginate(20);
        $totalHours = $query->sum('duration'); // Total jam untuk payroll

        return view('overtime.report', compact('overtimes', 'totalHours'));
    }
}