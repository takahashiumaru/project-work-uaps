<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OvertimeReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $overtimes;

    public function __construct(Collection $overtimes)
    {
        $this->overtimes = $overtimes;
    }

    public function collection()
    {
        return $this->overtimes;
    }

    public function headings(): array
    {
        return [
            'Nama Staff',
            'NIP',
            'Station',
            'Tanggal',
            'Durasi (Jam)',
            'Kegiatan',
            'Keterangan',
            'Disetujui Oleh'
        ];
    }

    public function map($ot): array
    {
        return [
            $ot->user->fullname ?? '-',
            $ot->user_id,
            $ot->user->station ?? '-',
            date('d M Y', strtotime($ot->date)),
            $ot->duration,
            $ot->title,
            $ot->description,
            $ot->approved_by ?? '-'
        ];
    }
}
