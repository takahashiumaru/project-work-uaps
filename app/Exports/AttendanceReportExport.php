<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceReportExport implements FromCollection, WithHeadings
{
    protected $attendances;

    public function __construct(Collection $attendances)
    {
        $this->attendances = $attendances;
    }

    // Kirim data ke Excel
    public function collection()
    {
        return $this->attendances->map(function ($row) {

            $attendance = $row->attendance ?? null;
            $schedule = $row->schedule ?? null;
            $date = \Carbon\Carbon::parse($row->date);

            $shiftLabel = $schedule
                ? $schedule->shift_description . ' (' . $schedule->start_time . '-' . $schedule->end_time . ')'
                : 'Libur';

            $checkIn = $attendance?->check_in_time
                ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s')
                : '-';

            $checkOut = $attendance?->check_out_time
                ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i:s')
                : '-';

            $workDuration = ($attendance?->check_in_time && $attendance?->check_out_time)
                ? \Carbon\Carbon::parse($attendance->check_in_time)
                ->diff(\Carbon\Carbon::parse($attendance->check_out_time))
                ->format('%H:%I:%S')
                : '-';

            return [
                'Tanggal' => $date->translatedFormat('d M Y'),
                'Nama' => $row->user->fullname ?? '-',
                'NIP' => $row->user->id ?? '-',
                'Check-in' => $checkIn,
                'Check-out' => $checkOut,
                'Lokasi' => $attendance ? $row->user->station : '-',
                'Durasi Kerja' => $workDuration,
            ];
        });
    }

    // Heading kolom
    public function headings(): array
    {
        return ['Tanggal', 'Nama', 'NIP', 'Check-in', 'Check-out', 'Lokasi',  'Durasi Kerja'];
    }
}
