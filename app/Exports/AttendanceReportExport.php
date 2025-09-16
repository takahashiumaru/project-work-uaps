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
        return $this->attendances->map(function($row) {
            $attendance = $row['attendance'];
            $schedule = $row['schedule'];
            $date = \Carbon\Carbon::parse($row['date']);

            $shiftLabel = $schedule
                ? $schedule->shift_description . ' (' . $schedule->start_time . '-' . $schedule->end_time . ')'
                : 'Libur';

            $checkIn = $attendance?->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') : '-';
            $checkOut = $attendance?->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i:s') : '-';
            $workDuration = ($checkIn != '-' && $checkOut != '-')
                ? \Carbon\Carbon::parse($attendance->check_in_time)->diff(\Carbon\Carbon::parse($attendance->check_out_time))->format('%H:%I:%S')
                : '-';

            return [
                'Tanggal' => $date->translatedFormat('d M Y'),
                'Shift' => $shiftLabel,
                'Check-in' => $checkIn,
                'Status' => $attendance->status ?? '-',
                'Lokasi' => $attendance->location ?? $attendance->check_in_notes ?? '-',
                'Check-out' => $checkOut,
                'Durasi Kerja' => $workDuration,
                'Catatan' => $attendance->notes ?? '-',
            ];
        });
    }

    // Heading kolom
    public function headings(): array
    {
        return ['Tanggal','Shift','Check-in','Status','Lokasi','Check-out','Durasi Kerja','Catatan'];
    }
}
