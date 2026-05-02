<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeavesReportExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $leaves;

    public function __construct($leaves)
    {
        $this->leaves = $leaves instanceof Collection ? $leaves : collect($leaves);
    }

    public function collection()
    {
        return $this->leaves->map(function ($leave) {
            $status = match ($leave->status ?? '') {
                'pending Apron', 'pending Bge' => 'Menunggu Leader',
                'pending'                       => 'Menunggu HO',
                'approved'                      => 'Disetujui',
                'rejected by leader'            => 'Ditolak Leader',
                'rejected by ho'                => 'Ditolak HO',
                default                         => $leave->status ?? '-',
            };

            return [
                'NIP'           => $leave->user_nip    ?? ($leave->user->id       ?? '-'),
                'Nama'          => $leave->user_leave  ?? ($leave->user->fullname  ?? '-'),
                'Station'       => $leave->station     ?? ($leave->user->station   ?? '-'),
                'Jenis Cuti'    => $leave->leave_type  ?? '-',
                'Mulai'         => $leave->start_date  ? \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d M Y') : '-',
                'Selesai'       => $leave->end_date    ? \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d M Y') : '-',
                'Total Hari'    => $leave->total_days  ?? 0,
                'Status'        => $status,
                'Keterangan'    => $leave->reason      ?? '-',
                'Approver'      => $leave->user_approve  ?? '-',
                'Tgl Approve'   => $leave->approved_at   ? \Carbon\Carbon::parse($leave->approved_at)->translatedFormat('d M Y H:i') : '-',
                'Rejector'      => $leave->user_rejected ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIP', 'Nama', 'Station', 'Jenis Cuti',
            'Mulai', 'Selesai', 'Total Hari', 'Status',
            'Keterangan', 'Approver', 'Tgl Approve', 'Rejector',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF111827']],
            ],
        ];
    }
}
