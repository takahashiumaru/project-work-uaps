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

    protected $fillable = [
        'fullname',
        'role',
        'station',
        'email',
        'phone',
        'gender',
        'password',
        'join_date',
        'contract_start',
        'contract_end',
        'pas_registered',
        'pas_expired',
        'salary',
        'profile_picture',
        'is_qantas',
        'pic_id', // DITAMBAHKAN: Untuk menentukan siapa PIC user ini.
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'join_date' => 'date',
            'contract_start' => 'date',
            'contract_end' => 'date',
            'pas_registered' => 'date',
            'pas_expired' => 'date',
            'is_qantas' => 'boolean',
        ];
    }

    // Relasi yang sudah ada
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    
    /**
     * DITAMBAHKAN: Mendapatkan data PIC dari user ini.
     */
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    /**
     * DITAMBAHKAN: Mendapatkan semua bawahan dari user ini (jika dia adalah seorang PIC).
     */
    public function subordinates()
    {
        return $this->hasMany(User::class, 'pic_id');
    }

    public function isAdmin()
    {
        return $this->role === 'Admin';
    }

}

