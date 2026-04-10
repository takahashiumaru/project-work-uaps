<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;

class StaffImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $rows->shift(); // skip header

        foreach ($rows as $row) {

            User::updateOrCreate(
                [
                    'id' => $row[0],
                ],
                [
                    'fullname'        => $row[1],
                    'email'           => $row[2],
                    'phone'           => $row[3],
                    'no_hp'           => $row[3],
                    'role'            => strtoupper($row[4]),
                    'station'         => $row[5],
                    'gender'          => $row[6],
                    'join_date'       => $this->formatDate($row[7]),
                    'salary'          => $row[8],
                    'contract_start'  => $this->formatDate($row[9]),
                    'contract_end'    => $this->formatDate($row[10]),
                    'no_pas'          => $row[11],
                    'pas_registered'  => $row[12],
                    'pas_expired'     => $this->formatDate($row[13]),
                    'bpjs_tk'         => $row[14],
                    'bpjs_kesehatan'  => $row[15],
                    'no_kk'           => $row[16],
                    'no_nik'          => $row[17],
                    'tempat_lahir'    => $row[18],
                    'tanggal_lahir'   => $this->formatDate($row[19]),
                    'job_title'           => $row[20],
                    'password'        => Hash::make('password123'),

                ]
            );
        }
    }

    private function formatDate($value)
    {
        if (!$value) return null;

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
