<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StaffExport implements FromCollection, WithHeadings, WithMapping
{
    protected $station;

    // Bisa filter by station jika admin mau download per station
    public function __construct($station = null)
    {
        $this->station = $station;
    }

    public function collection()
    {
        $query = User::query();
        if ($this->station) {
            $query->where('station', $this->station);
        }
        return $query->get();
    }

    public function map($user): array
    {
        return [
            $user->id,          // NIP / ID
            $user->fullname,
            $user->email,
            $user->role,        // Contoh: Porter Apron
            $user->station,     // Contoh: CGK
            $user->gender,      // Male/Female
            $user->join_date,   // Format YYYY-MM-DD
            $user->salary,
            $user->contract_start,
            $user->contract_end,
            $user->no_pas,
            $user->pas_expired,
        ];
    }

    public function headings(): array
    {
        return [
            'ID/NIP',
            'Nama Lengkap',
            'Email',
            'Role',
            'Station Code',
            'Gender',
            'Tanggal Gabung',
            'Gaji',
            'Mulai Kontrak',
            'Selesai Kontrak',
            'No PAS',
            'PAS Expired',
        ];
    }
}