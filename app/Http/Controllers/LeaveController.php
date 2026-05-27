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
    private const ANNUAL_LEAVE_QUOTA_DAYS = 12;

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

        if (!in_array($user->role, ['Leader Bge', 'Leader Apron', 'Ass Leader Apron', 'Ass Leader Bge', 'Admin', 'SPV', 'Head Of Airport Service'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika bukan admin/atasan, hanya tampilkan data miliknya
        if (!in_array($user->role, ['Leader Bge', 'Leader Apron', 'Ass Leader Apron', 'Ass Leader Bge', 'Admin', 'SPV', 'Head Of Airport Service'])) {
            $query->where('user_id', $user->id);
        }
        if ($user->station == 'Ho') {
            $query->orWhere('leaves.status', 'pending');
        }

        // Search Filter
        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('users.fullname', 'LIKE', "%{$search}%")
                  ->orWhere('users.id', 'LIKE', "%{$search}%")
                  ->orWhere('leaves.reason', 'LIKE', "%{$search}%");
            });
        }

        $leaves = $query->paginate(10)->withQueryString(); // Paginasi data

        // --- Logika Perhitungan Sisa Cuti ---
        $annualLeaveUsage = $this->annualLeaveUsage($user->id);
        $usedLeaveDays = $annualLeaveUsage['used'];
        $leaveBalance = $annualLeaveUsage['balance'];

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
        if (!in_array($user->role, ['Leader Bge', 'Leader Apron', 'Ass Leader Apron', 'Ass Leader Bge', 'Admin', 'SPV',  'Head Of Airport Service'])) {
            $query->where('user_id', $user->id);
        }
        if ($user->role == 'Head Of Airport Service') {
            $query->orWhere('leaves.status', 'pending');
        }

        // Search Filter
        if ($search = request('search')) {
            $query->where(function($q) use ($search) {
                $q->where('users.fullname', 'LIKE', "%{$search}%")
                  ->orWhere('users.id', 'LIKE', "%{$search}%")
                  ->orWhere('leaves.reason', 'LIKE', "%{$search}%");
            });
        }

        $leaves = $query->paginate(10)->withQueryString(); // Paginasi data

        // --- Logika Perhitungan Sisa Cuti ---
        $annualLeaveUsage = $this->annualLeaveUsage($user->id);
        $usedLeaveDays = $annualLeaveUsage['used'];
        $leaveBalance = $annualLeaveUsage['balance'];

        return view('leaves.pengajuan', compact('leaves', 'user', 'leaveBalance', 'usedLeaveDays'));
    }

    public function laporan(Request $request)
    {
        $authUser = Auth::user();

        $year = $request->year ?? date('Y');

        // Ambil data leaves join users (pemohon, approver, rejector)
        $query = \App\Models\Leave::join('users as u', 'leaves.user_id', '=', 'u.id')
            ->leftJoin('users as approved', 'leaves.approved_by', '=', 'approved.id')
            ->leftJoin('users as rejected', 'leaves.rejected_by', '=', 'rejected.id')
            ->whereYear('leaves.start_date', $year)
            ->select(
                'leaves.*',
                'u.id as user_id',
                'u.fullname as user_leave',
                'u.station as station',
                'approved.fullname as user_approve',
                'rejected.fullname as user_rejected'
            )
            ->orderBy('leaves.created_at', 'asc');

        if ($request->filled('user_name')) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw("CAST(u.id AS CHAR) LIKE ?", ["%{$request->user_name}%"])
                    ->orWhere('u.fullname', 'LIKE', "%{$request->user_name}%");
            });
        }

        $perPage = $request->input('per_page', 10);
        $leaves = $query->paginate($perPage)->withQueryString();

        return view('leaves.laporan', compact('leaves'));
    }

    public function export(Request $request)
    {
        $year = $request->input('year', date('Y'));

        // Build query with joins to get full data matching the laporan view
        $query = \App\Models\Leave::join('users as u', 'leaves.user_id', '=', 'u.id')
            ->leftJoin('users as approved', 'leaves.approved_by', '=', 'approved.id')
            ->leftJoin('users as rejected', 'leaves.rejected_by', '=', 'rejected.id')
            ->whereYear('leaves.start_date', $year)
            ->select(
                'leaves.*',
                'u.id as user_nip',
                'u.fullname as user_leave',
                'u.station as station',
                'approved.fullname as user_approve',
                'rejected.fullname as user_rejected'
            )
            ->orderBy('u.fullname')
            ->orderBy('leaves.start_date');

        // Optional: filter by specific user
        if ($request->filled('user_name')) {
            $query->where(function ($q) use ($request) {
                $q->whereRaw("CAST(u.id AS CHAR) LIKE ?", ["%{$request->user_name}%"])
                  ->orWhere('u.fullname', 'LIKE', "%{$request->user_name}%");
            });
        }

        $leaves = $query->get();

        $userLabel = $request->filled('user_name') ? '_' . preg_replace('/[^A-Za-z0-9]/', '_', $request->user_name) : '_Semua';
        $fileName = 'Laporan_Cuti' . $userLabel . '_' . $year . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LeavesReportExport($leaves),
            $fileName
        );
    }

    /**
     * Menampilkan form pengajuan cuti.
     */
    public function create()
    {
        // Ambil data sisa cuti untuk ditampilkan di form
        $user = Auth::user();
        $annualLeaveUsage = $this->annualLeaveUsage($user->id);
        $leaveBalance = $annualLeaveUsage['balance'];

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

        if ($user->role === 'Admin') {
            $status = 'approved';
        } else if ($user->role === 'Porter Bge') {
            $status = 'pending Bge';
        } else if ($user->role === 'Porter Apron') {
            $status = 'pending Apron';
        } else {
            $status = 'pending';
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $annualLeaveDecision = null;
        $isAutomaticallyRejected = false;

        // Cek sisa cuti jika jenisnya adalah 'Cuti Tahunan'
        if ($request->leave_type === 'Cuti Tahunan') {
            $annualLeaveDecision = $this->annualLeaveDecision($user->id, $startDate, $totalDays);

            if ($annualLeaveDecision['exceeds']) {
                $status = 'rejected by ho';
                $isAutomaticallyRejected = true;
            }
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave_attachments', 'public');
        }

        $leaveData = [
            'user_id'       => Auth::id(),
            'leave_type'    => $request->leave_type,
            'start_date'    => $startDate,
            'end_date'      => $endDate,
            'reason'        => $request->reason,
            'total_days'    => $totalDays,
            'attachment_path' => $attachmentPath,
            'replacement_employee_name' => $request->replacement_employee_name,
            'status'        => $status,
        ];

        if ($isAutomaticallyRejected) {
            $leaveData['manager_comment'] = $this->annualLeaveRejectionComment($annualLeaveDecision);
        } elseif ($status === 'approved') {
            $leaveData['approved_by'] = Auth::id();
            $leaveData['approved_at'] = now();
        }

        Leave::create($leaveData);

        if ($isAutomaticallyRejected) {
            Alert::warning('Ditolak Otomatis', 'Pengajuan cuti tahunan melebihi kuota 12 hari dan otomatis ditolak.');
            return redirect()->route('leaves.pengajuan');
        }

        Alert::success('Berhasil', 'Pengajuan Anda telah berhasil dikirim.');
        return redirect()->route('leaves.pengajuan');
    }

    /**
     * Mengubah status pengajuan (approve/reject).
     */
    public function updateStatus(Request $request, Leave $leave)
    {
        $validStatuses = ['approved', 'rejected by ho', 'pending', 'rejected by leader'];

        $request->validate([
            'status' => ['required', Rule::in($validStatuses)]
        ]);

        $status = $request->status;

        if ($status === 'approved' && $leave->leave_type === 'Cuti Tahunan') {
            $annualLeaveDecision = $this->annualLeaveDecision(
                $leave->user_id,
                Carbon::parse($leave->start_date),
                (int) $leave->total_days,
                $leave->id
            );

            if ($annualLeaveDecision['exceeds']) {
                $leave->status = 'rejected by ho';
                $leave->rejected_by = Auth::id();
                $leave->approved_by = null;
                $leave->approved_at = null;
                $leave->manager_comment = $this->annualLeaveRejectionComment($annualLeaveDecision);
                $leave->save();

                Alert::warning('Ditolak Otomatis', 'Cuti tahunan ini melebihi kuota 12 hari, sehingga otomatis ditolak.');
                return redirect()->route('leaves.index');
            }
        }

        $leave->status = $status;

        if ($status == 'approved') {
            $leave->approved_by = Auth::id();
            $leave->approved_at = now();
            $leave->rejected_by = null;
        } elseif (str_starts_with($status, 'rejected')) {
            $leave->rejected_by = Auth::id();
            $leave->approved_by = null;
            $leave->approved_at = null;
        } else {
            $leave->rejected_by = null;
        }

        $leave->save();

        Alert::success('Berhasil', 'Status pengajuan telah diubah.');
        return redirect()->route('leaves.index');
    }

    private function annualLeaveUsage(string $userId, ?int $year = null, ?int $excludeLeaveId = null): array
    {
        $year ??= (int) date('Y');

        $query = Leave::where('user_id', $userId)
            ->where('status', 'approved')
            ->where('leave_type', 'Cuti Tahunan')
            ->whereYear('start_date', $year);

        if ($excludeLeaveId !== null) {
            $query->where('id', '!=', $excludeLeaveId);
        }

        $used = (int) $query->sum('total_days');

        return [
            'quota' => self::ANNUAL_LEAVE_QUOTA_DAYS,
            'used' => $used,
            'balance' => max(0, self::ANNUAL_LEAVE_QUOTA_DAYS - $used),
            'raw_balance' => self::ANNUAL_LEAVE_QUOTA_DAYS - $used,
            'year' => $year,
        ];
    }

    private function annualLeaveDecision(string $userId, Carbon $startDate, int $requestedDays, ?int $excludeLeaveId = null): array
    {
        $usage = $this->annualLeaveUsage($userId, (int) $startDate->year, $excludeLeaveId);
        $projected = $usage['used'] + $requestedDays;

        return array_merge($usage, [
            'requested' => $requestedDays,
            'projected' => $projected,
            'exceeds' => $projected > self::ANNUAL_LEAVE_QUOTA_DAYS,
        ]);
    }

    private function annualLeaveRejectionComment(array $decision): string
    {
        return sprintf(
            'Otomatis ditolak karena total cuti tahunan %d menjadi %d hari, melebihi kuota %d hari.',
            $decision['year'],
            $decision['projected'],
            $decision['quota']
        );
    }
}
