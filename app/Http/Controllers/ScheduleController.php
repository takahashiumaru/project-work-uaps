<?php

namespace App\Http\Controllers;

use App\Models\Freelance;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        print_r($userId);
        $currentDate = Carbon::now();
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        $schedules = Schedule::with('shift')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));

        return view('schedule.index', [
            'schedules' => $schedules,
            'startDay' => $startOfMonth->dayOfWeek,
            'daysInMonth' => $currentDate->daysInMonth,
            'year' => $currentDate->year,
            'month' => $currentDate->month,
        ]);
    }

    public function now()
    {
        $today = Carbon::today();
        $nowTime = Carbon::now('Asia/Jakarta')->format('H:i:s');

        $schedules = Schedule::with('shift', 'user', 'freelance')
            ->whereDate('date', $today)
            ->get();

        $groupedByShift = $schedules->groupBy('shift_id');

        $ordered = collect();

        foreach ($groupedByShift as $shiftId => $group) {
            $shift = $group->first()->shift;

            if (!$shift) continue;

            $start = $shift->start_time;
            $end = $shift->end_time;

            if ($nowTime >= $start && $nowTime <= $end) {
                $ordered->prepend(['shift' => $shift, 'schedules' => $group]);
            } elseif ($nowTime < $start) {
                $ordered->push(['shift' => $shift, 'schedules' => $group]);
            } else {
                $ordered->add(['shift' => $shift, 'schedules' => $group]);
            }
        }

        return view('schedule.now', [
            'shiftsGrouped' => $ordered,
            'today' => $today,
        ]);
    }

    public function autoCreate()
    {
        if (!in_array(Auth::user()->role, ['SPV Bge', 'SPV Apron'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
        try {
            $startDate = Carbon::now()->startOfMonth();
            $endDate   = Carbon::now()->endOfMonth();
            $roleSpv = Auth::user()->role;
            $rolePorter = null;

            if ($roleSpv === 'SPV Bge') {
                $rolePorter = 'Porter Bge';
            } elseif ($roleSpv === 'SPV Apron') {
                $rolePorter = 'Porter Apron';
            }

            // Cegah duplikasi jadwal sebulan penuh
            $existing = DB::table('schedules')
                ->whereBetween('date', [$startDate->toDateString(), $endDate->toDateString()])
                ->whereIn('user_id', function ($query) use ($rolePorter) {
                    $query->select('id')
                        ->from('users')
                        ->where('role', $rolePorter);
                })
                ->exists();

            if ($existing) {
                Alert::info('Informasi', "Data jadwal untuk $rolePorter bulan ini sudah ada.");
                return back();
            }

            // Users (PORTER sesuai SPV)
            $users = DB::table('users')
                ->where('role', $rolePorter)
                ->select('id', 'is_qantas')
                ->orderBy('id')
                ->get();

            if ($users->isEmpty()) {
                Alert::warning('Perhatian', "Tidak ada user dengan role $rolePorter.");
                return back();
            }

            // Shifts
            $activeShifts = DB::table('shifts')
                ->where('id', '!=', 'off')
                ->select('id', 'use_manpower')
                ->get();

            $offShiftId = DB::table('shifts')->where('id', 'off')->value('id');
            if (!$offShiftId) {
                Alert::error('Terjadi Kesalahan', 'Shift OFF (id=off) tidak ditemukan.');
                return back();
            }
            if ($activeShifts->isEmpty()) {
                Alert::error('Terjadi Kesalahan', 'Tidak ada shift aktif.');
                return back();
            }

            // Target Qantas per manpower (mengacu instruksi terbaru)
            // 14/12/10 → 2 Qantas; 8/6 → Qantas saja (fallback Non-Qantas jika Qantas tidak mencukupi)
            $qantasTarget = [
                14 => ['prefer' => 4, 'only_qantas' => false],
                12 => ['prefer' => 4, 'only_qantas' => false],
                10 => ['prefer' => 4, 'only_qantas' => false],
                8 => ['prefer' => 2, 'only_qantas' => false], // full oleh Qantas
                6 => ['prefer' => 2, 'only_qantas' => false], // full oleh Qantas
            ];

            // --- Sinkron fase 8-hari dari bulan sebelumnya (pakai 8 hari lookback) ---
            $initialPhase = $this->inferInitialPhases($users, $startDate, $offShiftId);

            $totalDays = $startDate->diffInDays($endDate) + 1;

            DB::beginTransaction();

            // Map fase berjalan (in-memory) user_id => 0..7
            $phaseMap = $initialPhase;

            // Susun urutan shift stabil (array id)
            $shiftOrder = $activeShifts->pluck('id')->values()->toArray();
            $shiftUse   = $activeShifts->mapWithKeys(fn($s) => [$s->id => (int)$s->use_manpower])->toArray();

            for ($d = 0; $d < $totalDays; $d++) {
                $currentDate = $startDate->copy()->addDays($d)->toDateString();

                $currentDate = $startDate->copy()->addDays($d)->toDateString();

                // Guard: jangan lewat dari akhir bulan
                if ($currentDate > $endDate->toDateString()) {
                    break;
                }

                // Bagi user berdasarkan fase hari ini
                $workingQantas    = [];
                $workingNonQantas = [];
                $offToday         = [];

                foreach ($users as $u) {
                    $phase = $phaseMap[$u->id] ?? 0;        // 0..7
                    $isWork = $phase < 6;                   // 0..5 kerja, 6..7 off
                    if ($isWork) {
                        if ((int)$u->is_qantas === 1) $workingQantas[] = $u->id;
                        else                             $workingNonQantas[] = $u->id;
                    } else {
                        $offToday[] = $u->id;
                    }
                }

                // Rotasi harian (tanpa random): pancar merata
                $workingQantas    = $this->rotateArray($workingQantas, $d % max(1, count($workingQantas)));
                $workingNonQantas = $this->rotateArray($workingNonQantas, ($d + 1) % max(1, count($workingNonQantas)));
                $dayShiftOrder    = $this->rotateArray($shiftOrder, $d % max(1, count($shiftOrder)));

                // Track pemakaian user / kapasitas per shift hari ini
                $usedToday          = [];                               // user_id => true
                $assignedPerShift   = array_fill_keys($shiftOrder, 0);  // shift_id => count
                $qantasPerShift     = array_fill_keys($shiftOrder, 0);  // shift_id => count Qantas

                // Helper lambda: pick n dari pool yang belum used
                $pick = function (array &$pool, array &$used, int $n) {
                    $picked = [];
                    foreach ($pool as $uid) {
                        if (!isset($used[$uid])) {
                            $picked[] = $uid;
                            $used[$uid] = true;
                            if (count($picked) >= $n) break;
                        }
                    }
                    return $picked;
                };

                // PASS 1: penuhi target Qantas per shift
                foreach ($dayShiftOrder as $sid) {
                    $limit = $shiftUse[$sid] ?? 0;
                    if ($limit <= 0) continue;

                    $rule = $qantasTarget[$limit] ?? ['prefer' => 0, 'only_qantas' => false];
                    $targetQ = $rule['only_qantas'] ? min($limit, $this->availableCount($workingQantas, $usedToday))
                        : min($rule['prefer'], $this->availableCount($workingQantas, $usedToday), $limit);

                    if ($targetQ > 0) {
                        $picked = $pick($workingQantas, $usedToday, $targetQ);
                        foreach ($picked as $uid) {
                            $this->upsertSchedule($uid, $currentDate, $sid);
                            $assignedPerShift[$sid]++;
                            $qantasPerShift[$sid]++;
                        }
                    }
                }

                // PASS 2: isi sisa kapasitas
                foreach ($dayShiftOrder as $sid) {
                    $limit = $shiftUse[$sid];
                    $remain = $limit - $assignedPerShift[$sid];
                    if ($remain <= 0) continue;

                    $rule = $qantasTarget[$limit] ?? ['prefer' => 0, 'only_qantas' => false];

                    if ($rule['only_qantas']) {
                        // Prioritas Qantas saja; kalau Qantas kurang → fallback Non-Qantas
                        $takeQ = min($remain, $this->availableCount($workingQantas, $usedToday));
                        if ($takeQ > 0) {
                            $picked = $pick($workingQantas, $usedToday, $takeQ);
                            foreach ($picked as $uid) {
                                $this->upsertSchedule($uid, $currentDate, $sid);
                                $assignedPerShift[$sid]++;
                                $qantasPerShift[$sid]++;
                            }
                            $remain = $limit - $assignedPerShift[$sid];
                        }
                        // Fallback
                        if ($remain > 0 && $this->availableCount($workingNonQantas, $usedToday) > 0) {
                            $takeNQ = min($remain, $this->availableCount($workingNonQantas, $usedToday));
                            $picked = $pick($workingNonQantas, $usedToday, $takeNQ);
                            foreach ($picked as $uid) {
                                $this->upsertSchedule($uid, $currentDate, $sid);
                                $assignedPerShift[$sid]++;
                            }
                        }
                    } else {
                        // 14/12/10 → isi sisa dengan Non-Qantas dulu
                        if ($this->availableCount($workingNonQantas, $usedToday) > 0) {
                            $takeNQ = min($remain, $this->availableCount($workingNonQantas, $usedToday));
                            $picked = $pick($workingNonQantas, $usedToday, $takeNQ);
                            foreach ($picked as $uid) {
                                $this->upsertSchedule($uid, $currentDate, $sid);
                                $assignedPerShift[$sid]++;
                            }
                            $remain = $limit - $assignedPerShift[$sid];
                        }
                        // lalu kalau masih ada slot, tambal Qantas lagi
                        if ($remain > 0 && $this->availableCount($workingQantas, $usedToday) > 0) {
                            $takeQ2 = min($remain, $this->availableCount($workingQantas, $usedToday));
                            $picked = $pick($workingQantas, $usedToday, $takeQ2);
                            foreach ($picked as $uid) {
                                $this->upsertSchedule($uid, $currentDate, $sid);
                                $assignedPerShift[$sid]++;
                                $qantasPerShift[$sid]++;
                            }
                        }
                    }
                }

                // PASS 3: pastikan semua user yang statusnya "kerja" tapi belum kepakai → OFF (biar 1 orang 1 jadwal/hari)
                foreach (array_merge($workingQantas, $workingNonQantas) as $uid) {
                    if (!isset($usedToday[$uid])) {
                        $this->upsertSchedule($uid, $currentDate, $offShiftId);
                        $usedToday[$uid] = true;
                    }
                }

                // PASS 4: yang memang fase-nya off → OFF (id=off)
                foreach ($offToday as $uid) {
                    $this->upsertSchedule($uid, $currentDate, $offShiftId);
                    $usedToday[$uid] = true;
                }

                // Majuin fase 1 hari untuk semua user
                foreach ($users as $u) {
                    $phaseMap[$u->id] = (($phaseMap[$u->id] ?? 0) + 1) % 8;
                }
            }

            DB::commit();
            Alert::success('Success', 'Auto create berhasil dilakukan');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat auto create: ' . $e->getMessage());
            Alert::error('Terjadi Kesalahan', 'Gagal melakukan auto create.');
            return back();
        }
    }

    // -------- Helpers --------

    /** Sinkron fase 8-hari berdasarkan 8 hari terakhir sebelum awal bulan. */
    private function inferInitialPhases($users, Carbon $startDate, $offShiftId): array
    {
        $lookbackDays = 8; // penting: 8 hari, bukan 7
        $from = $startDate->copy()->subDays($lookbackDays)->toDateString();
        $to   = $startDate->copy()->subDay()->toDateString();

        $raw = DB::table('schedules')
            ->whereBetween('date', [$from, $to])
            ->whereIn('user_id', $users->pluck('id'))
            ->select('user_id', 'date', 'shift_id')
            ->get()
            ->groupBy('user_id');

        $phaseMap = [];

        foreach ($users as $u) {
            $records = $raw->get($u->id, collect());

            // history D-8..D-1 (total 8 entry): true=kerja, false=off, null=unknown
            $history = [];
            for ($d = $lookbackDays; $d >= 1; $d--) {
                $day = $startDate->copy()->subDays($d)->toDateString();
                $rec = $records->firstWhere('date', $day);
                if ($rec) {
                    $history[] = ($rec->shift_id !== $offShiftId);
                } else {
                    $history[] = null;
                }
            }

            $phase = $this->matchPhaseFromHistory($history);
            if ($phase === null) {
                // Sebar merata pakai hash id → stabil & tanpa kolom baru
                $phase = (crc32((string)$u->id) % 8);
            }
            $phaseMap[$u->id] = $phase;
        }

        return $phaseMap;
    }

    /** Cocokkan fase 0..7 terhadap history kerja/off (true/false/null) lookback=8. */
    private function matchPhaseFromHistory(array $history): ?int
    {
        // Siklus: index 0..5 kerja (true), 6..7 off (false)
        $cycle = [true, true, true, true, true, true, false, false];
        $lookback = count($history); // 8

        for ($p = 0; $p < 8; $p++) {
            $ok = true;
            for ($i = 0; $i < $lookback; $i++) {
                if ($history[$i] === null) continue;
                // hari i (0..7) = D-(8-i) → delta 8..1
                $delta = $lookback - $i;
                $idx = ($p - $delta) % 8;
                if ($idx < 0) $idx += 8;
                if ($cycle[$idx] !== $history[$i]) {
                    $ok = false;
                    break;
                }
            }
            if ($ok) return $p;
        }
        return null;
    }

    /** Rotasi array ke kiri sebanyak $offset. */
    private function rotateArray(array $arr, int $offset): array
    {
        $n = count($arr);
        if ($n === 0) return $arr;
        $k = $offset % $n;
        if ($k === 0) return $arr;
        return array_merge(array_slice($arr, $k), array_slice($arr, 0, $k));
    }

    /** Hitung sisa yang belum dipakai dari pool. */
    private function availableCount(array $pool, array $usedToday): int
    {
        $c = 0;
        foreach ($pool as $uid) if (!isset($usedToday[$uid])) $c++;
        return $c;
    }

    /** Upsert jadwal (1 user 1 tanggal). */
    private function upsertSchedule($userId, $date, $shiftId): void
    {
        DB::table('schedules')->updateOrInsert(
            ['user_id' => $userId, 'date' => $date],
            ['shift_id' => $shiftId]
        );
    }



    public function show(): View
    {
        if (!in_array(Auth::user()->role, ['SPV Bge', 'SPV Apron'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $roleSpv = Auth::user()->role;
        $rolePorter = null;

        if ($roleSpv === 'SPV Bge') {
            $rolePorter = 'Porter Bge';
        } elseif ($roleSpv === 'SPV Apron') {
            $rolePorter = 'Porter Apron';
        }

        $search = request('search');

        $user = user::where('role', 'like', "%{$rolePorter}%")->when($search, function ($query, $search) {
            return $query->where('fullname', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        })
            ->orderBy('fullname', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('schedule.show', [
            'user' => $user,
        ]);
    }

    public function freelances(): View
    {
        $search = request('search');

        $freelance = Freelance::where('role', '=', 'Freelance')->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('id', 'like', "%{$search}%");
        })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();


        return view('schedule.freelance.freelances', [
            'user' => $freelance,
        ]);
    }

    public function freelanceCreate(): View
    {
        return view('schedule.freelance.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        try {
            $freelance = new Freelance();
            $freelance->name = $request->fullname;
            $freelance->email = $request->email;
            $freelance->role = 'Freelance';

            $freelance->save();

            Alert::success('Success', 'User berhasil ditambahkan.');
            return redirect()->route('schedule.freelances');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function edit(Request $request, $id)
    {
        $page = $request->get('page', 1);

        $user = User::findOrFail($id);

        $currentDate = Carbon::now();
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        $schedules = Schedule::with('shift')
            ->where('user_id', $id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get()
            ->keyBy(fn($item) => Carbon::parse($item->date)->format('Y-m-d'));

        return view('schedule.edit', compact(
            'user',
            'page',
            'schedules',
            'startOfMonth',
            'currentDate',
            'endOfMonth'
        ))->with([
            'startDay' => $startOfMonth->dayOfWeek,
            'daysInMonth' => $currentDate->daysInMonth,
            'year' => $currentDate->year,
            'month' => $currentDate->month,
            'userId' => $id,
        ]);
    }

    public function update(Request $request, $userId, $date)
    {
        try {
            $shiftId = $request->input('shift_id');

            $updated = \App\Models\Schedule::where('user_id', $userId)
                ->where('date', $date)
                ->update(['shift_id' => $shiftId]);
            DB::commit();
            Alert::success('Success', 'Data berhasil diupdate');
            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saat melalukan update data: ' . $e->getMessage());
            Alert::error('Terjadi Kesalahan', 'Gagal melalukan update data.');
            return back();
        }
    }
    public function updateActive(Request $request)
    {
        $schedule = Schedule::findOrFail($request->id);
        $schedule->is_active = $request->is_active;
        $schedule->save();

        return response()->json(['message' => 'Status aktif staff diperbarui']);
    }
}
