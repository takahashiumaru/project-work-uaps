<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeavesReportExport implements FromCollection, WithHeadings
{
    protected $leaves;

    public function __construct(Collection $leaves)
    {
        $this->leaves = $leaves;
    }

    // Data yang akan diexport ke Excel
    public function collection()
    {
        return $this->leaves->map(function ($leave) {
            return [
                'Tanggal Pengajuan' => \Carbon\Carbon::parse($leave->created_at)->translatedFormat('d M Y'),
                'Jenis Cuti'        => $leave->leave_type ?? '-',
                'Mulai'             => $leave->start_date ? \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d M Y') : '-',
                'Selesai'           => $leave->end_date ? \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d M Y') : '-',
                'Total Hari'        => $leave->total_days ?? 0,
                'Status'            => $leave->status ?? '-',
                'Alasan'            => $leave->reason ?? '-',
                'Catatan Admin'     => $leave->notes ?? '-',
            ];
        });
    }

    // Heading kolom
    public function headings(): array
    {
        return [
            'Tanggal Pengajuan',
            'Jenis Cuti',
            'Mulai',
            'Selesai',
            'Total Hari',
            'Status',
            'Alasan',
            'Catatan Admin',
        ];
    }
}
