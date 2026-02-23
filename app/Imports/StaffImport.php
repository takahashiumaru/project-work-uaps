<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StaffImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new User([
            'id'             => $row['id_nip'], // Pastikan header di CSV bernama 'id_nip'
            'fullname'       => $row['nama_lengkap'],
            'email'          => $row['email'],
            'password'       => Hash::make('password123'), // Default Password
            'role'           => $row['role'],
            'station'        => strtoupper($row['station_code']),
            'gender'         => $row['gender'],
            'join_date'      => $row['tanggal_gabung'] ?? date('Y-m-d'),
            'salary'         => $row['gaji'] ?? 0,
            'is_qantas'      => 0, // Default
            
            // Data Opsional (Kontrak & PAS)
            'contract_start' => $row['mulai_kontrak'] ?? null,
            'contract_end'   => $row['selesai_kontrak'] ?? null,
            'no_pas'         => $row['no_pas'] ?? null,
            'pas_expired'    => $row['pas_expired'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'id_nip'       => 'required|unique:users,id',
            'email'        => 'required|email|unique:users,email',
            'station_code' => 'required|exists:stations,code', // Wajib ada di tabel stations
            'role'         => 'required',
        ];
    }
}