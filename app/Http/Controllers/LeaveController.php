<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;
use App\Exports\LeavesReportExport;
use Maatwebsite\Excel\Facades\Excel;

class LeaveController extends Controller
{
    /**
     * Menampilkan daftar riwayat pengajuan cuti.
     * Admin melihat semua, user biasa hanya melihat miliknya.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Leave::with('user')
            ->select('leaves.*')
            ->join('users', 'users.id', '=', 'leaves.user_id')
            ->where('users.station', $user->station)
            ->latest(); // Eager load relasi user

        if (!in_array($user->role, ['SPV', 'ASS LEADER', 'CHIEF', 'LEADER', 'Admin'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika bukan admin/atasan, hanya tampilkan data miliknya
        if (!in_array($user->role, ['SPV', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            $query->where('user_id', $user->id);
        }
        if ($user->station == 'Ho') {
            $query->orWhere('leaves.status', 'pending');
        }

        $leaves = $query->paginate(10); // Paginasi data

        // --- Logika Perhitungan Sisa Cuti ---
        $totalLeaveQuota = 12; // Asumsi kuota cuti tahunan adalah 12 hari
        $usedLeaveDays = Leave::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('leave_type', 'Cuti Tahunan')
            ->whereYear('start_date', date('Y'))
            ->sum('total_days');

        $leaveBalance = $totalLeaveQuota - $usedLeaveDays;

        return view('leaves.index', compact('leaves', 'user', 'leaveBalance', 'usedLeaveDays'));
    }

    public function pengajuan()
    {
        $user = Auth::user();
        $query = Leave::with('user')
            ->select('leaves.*')
            ->join('users', 'users.id', '=', 'leaves.user_id')
            ->where('users.station', $user->station)
            ->latest(); // Eager load relasi user

        // Jika bukan admin/atasan, hanya tampilkan data miliknya
        if (!in_array($user->role, ['SPV', 'ASS LEADER', 'CHIEF', 'LEADER'])) {
            $query->where('user_id', $user->id);
        }
        if ($user->station == 'Ho') {
            $query->orWhere('leaves.status', 'pending');
        }

        $leaves = $query->paginate(10); // Paginasi data

        // --- Logika Perhitungan Sisa Cuti ---
        $totalLeaveQuota = 12; // Asumsi kuota cuti tahunan adalah 12 hari
        $usedLeaveDays = Leave::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('leave_type', 'Cuti Tahunan')
            ->whereYear('start_date', date('Y'))
            ->sum('total_days');

        $leaveBalance = $totalLeaveQuota - $usedLeaveDays;

        return view('leaves.pengajuan', compact('leaves', 'user', 'leaveBalance', 'usedLeaveDays'));
    }

    public function laporan(Request $request)
    {
        $authUser = Auth::user();

        // Jika belum ada filter user_name, tampilkan halaman kosong
        if (!$request->filled('user_name')) {
            return view('leaves.laporan', [
                'leaves' => collect(),
                'user' => null,
                'leaveBalance' => 0,
                'usedLeaveDays' => 0,
            ]);
        }

        // Ambil data leaves join users (pemohon, approver, rejector)
        $leaves = \App\Models\Leave::join('users as u', 'leaves.user_id', '=', 'u.id')
            ->leftJoin('users as approved', 'leaves.approved_by', '=', 'approved.id')
            ->leftJoin('users as rejected', 'leaves.rejected_by', '=', 'rejected.id')
            ->where(function ($q) use ($request) {
                $q->whereRaw("CAST(u.id AS CHAR) LIKE ?", ["%{$request->user_name}%"])
                    ->orWhere('u.fullname', 'LIKE', "%{$request->user_name}%");
            })
            ->select(
                'leaves.*',
                'u.id as user_id',
                'u.fullname as user_leave',
                'u.station as station',
                'approved.fullname as user_approve',
                'rejected.fullname as user_rejected'
            )
            ->orderBy('leaves.created_at', 'asc')
            ->paginate(10);

        // Ambil user (dari join)
        $user = $leaves->first() ? (object)[
            'id'       => $leaves->first()->user_id,
            'fullname' => $leaves->first()->user_leave,
            'station'  => $leaves->first()->station,
        ] : null;

        if (!$user) {
            return view('leaves.laporan', [
                'leaves' => collect(),
                'user' => null,
                'leaveBalance' => 0,
                'usedLeaveDays' => 0,
            ]);
        }

        // Hitung sisa cuti
        $totalLeaveQuota = 12;
        $usedLeaveDays = \App\Models\Leave::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('leave_type', 'Cuti Tahunan')
            ->whereYear('start_date', $request->year ?? date('Y'))
            ->sum('total_days');

        $leaveBalance = $totalLeaveQuota - $usedLeaveDays;

        return view('leaves.laporan', compact('leaves', 'user', 'leaveBalance', 'usedLeaveDays'));
    }

    public function export(Request $request)
    {
        if (!$request->filled('user_name')) {
            return redirect()->back()->with('error', 'Pilih karyawan terlebih dahulu.');
        }

        $user = \App\Models\User::where('id', $request->user_name)
            ->orWhere('fullname', 'LIKE', "%{$request->user_name}%")
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan.');
        }

        $leaves = \App\Models\Leave::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'Laporan_Leaves_' . $user->fullname . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\LeavesReportExport($leaves), $fileName);
    }

    /**
     * Menampilkan form pengajuan cuti.
     */
    public function create()
    {
        // Ambil data sisa cuti untuk ditampilkan di form
        $user = Auth::user();
        $totalLeaveQuota = 12; // Asumsi kuota
        $usedLeaveDays = Leave::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('leave_type', 'Cuti Tahunan')
            ->whereYear('start_date', date('Y'))
            ->sum('total_days');

        $leaveBalance = $totalLeaveQuota - $usedLeaveDays;

        return view('leaves.create', compact('leaveBalance'));
    }

    /**
     * Menyimpan data pengajuan cuti baru.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        // Validasi
        $request->validate([
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'reason'     => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'replacement_employee_name' => 'nullable|string|max:255',
        ]);

        $status = '';

        if ($user->station === 'Bge') {
            $status = 'pending Bge';
        } else if ($user->station === 'Apron') {
            $status = 'pending Apron';
        } else {
            $status = 'approved';
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        // Cek sisa cuti jika jenisnya adalah 'Cuti Tahunan'
        if ($request->leave_type === 'Cuti Tahunan') {
            $user = Auth::user();
            $totalLeaveQuota = 12;
            $usedLeaveDays = Leave::where('user_id', $user->id)
                ->where('status', 'approved')
                ->where('leave_type', 'Cuti Tahunan')
                ->whereYear('start_date', date('Y'))
                ->sum('total_days');
            $leaveBalance = $totalLeaveQuota - $usedLeaveDays;

            if ($totalDays > $leaveBalance) {
                Alert::error('Gagal', 'Sisa cuti tahunan Anda tidak mencukupi.');
                return redirect()->back()->withInput();
            }
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave_attachments', 'public');
        }

        Leave::create([
            'user_id'       => Auth::id(),
            'leave_type'    => $request->leave_type,
            'start_date'    => $startDate,
            'end_date'      => $endDate,
            'reason'        => $request->reason,
            'total_days'    => $totalDays,
            'attachment_path' => $attachmentPath,
            'replacement_employee_name' => $request->replacement_employee_name,
            'status'        => $status,
        ]);

        Alert::success('Berhasil', 'Pengajuan Anda telah berhasil dikirim.');
        return redirect()->route('leaves.pengajuan');
    }

    /**
     * Mengubah status pengajuan (approve/reject).
     */
    public function updateStatus(Request $request, Leave $leave)
    {
        $validStatuses = ['approved', 'rejected_by_ho', 'pending', 'rejected_by_pic'];

        $request->validate([
            'status' => ['required', Rule::in($validStatuses)]
        ]);

        $status = $request->status;

        $leave->status = $status;

        if ($status == 'approved') {
            $leave->approved_by = Auth::id();
            $leave->approved_at = now();
        } else {
            $leave->rejected_by = Auth::id();
        }

        $leave->save();

        Alert::success('Berhasil', 'Status pengajuan telah diubah.');
        return redirect()->route('leaves.index');
    }
}
