<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Exports\OvertimeReportExport;
use Maatwebsite\Excel\Facades\Excel;

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
                        ->paginate(10)
                        ->withQueryString();

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
    public function approvalList(Request $request)
    {
        $user = Auth::user();

        // Security Check: Hanya Admin/Leader yg boleh masuk
        if (!in_array($user->role, ['Admin', 'LEADER', 'Head Of Airport Service', 'ASS LEADER'])) {
            abort(403);
        }

        $query = Overtime::with('user')->where('status', 'Pending');

        // Filter Search (NIP / Nama)
        if ($search = $request->input('search')) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filter Station
        if ($user->role == 'Admin') {
            if ($request->filled('station')) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('station', $request->station);
                });
            }
        } else {
            // Jika BUKAN Admin, hanya tampilkan request dari Station yang sama
            $query->whereHas('user', function($q) use ($user) {
                $q->where('station', $user->station);
            });
        }

        $perPage = $request->input('per_page', 20);
        $pendingOvertimes = $query->orderBy('date', 'desc')->paginate($perPage)->withQueryString();

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
        $search = $request->input('search');

        // Filter Search (NIP / Nama)
        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

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

        $overtimes = $query->latest()->paginate(20)->withQueryString();
        $totalHours = $query->sum('duration'); // Total jam untuk payroll

        $stations = \App\Models\Station::where('is_active', 1)->orderBy('name', 'asc')->get();
        return view('overtime.report', compact('overtimes', 'totalHours', 'stations'));
    }

    public function exportExcel(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $query = Overtime::with('user')->where('status', 'Approved');
        $search = $request->input('search');

        if ($search) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->has('station') && $request->station != null) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('station', $request->station);
            });
        }
        
        if ($request->date_start && $request->date_end) {
            $query->whereBetween('date', [$request->date_start, $request->date_end]);
        }

        $overtimes = $query->latest()->get();

        return Excel::download(new OvertimeReportExport($overtimes), 'Laporan_Lembur_'.date('YmdHis').'.xlsx');
    }
}