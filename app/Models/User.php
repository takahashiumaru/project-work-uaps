<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Leave;
use App\Models\Certificate; // <--- PASTIKAN BARIS INI ADA!

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    
    use HasFactory, Notifiable;

 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // GABUNGKAN SEMUA KOLOM DISINI (JANGAN ADA DUA FILLABLE)
    protected $fillable = [
        // Identitas Utama
        'id',               // NIP atau NIK (Penting agar bisa diinput manual)
        'fullname',
        'email',
        'phone',
        'password',
        'gender',
        'profile_picture',
        
        // Pekerjaan & Status
        'role',             // Admin, Leader, Porter Apron, dll
        'station',          // CGK, SUB, dll
        'join_date',
        'salary',
        'is_qantas',
        'is_active',        // Fitur Manpower Control / Banned
        'pic_id',           // ID Atasan (Leader)

        // Data Kontrak
        'contract_start',
        'contract_end',

        // Data PAS Bandara
        'no_pas',
        'pas_registered',
        'pas_expired',

        // Data TIM (Tanda Izin Mengemudi) - BARU
        'tim_number',
        'tim_registered',
        'tim_expired',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            
            // Casting Tanggal (Penting agar tidak error saat format tanggal di View)
            'join_date' => 'date',
            'contract_start' => 'date',
            'contract_end' => 'date',
            'pas_registered' => 'date',
            'pas_expired' => 'date',
            'tim_expired' => 'date', // TIM
            
            // Boolean
            'is_qantas' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    // =================================================================
    // RELASI ANTAR TABEL
    // =================================================================

    // Relasi ke Cuti
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    // Relasi ke Sertifikat Training
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    
    // Relasi: User ini punya satu atasan (PIC)
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    // Relasi: User ini punya banyak bawahan (Jika dia Leader)
    public function subordinates()
    {
        return $this->hasMany(User::class, 'pic_id');
    }

    // Helper Function
    public function isAdmin()
    {
        return $this->role === 'Admin';
    }
    // Relasi ke Lembur
    public function overtimes()
    {
        return $this->hasMany(Overtime::class);
    }
}

