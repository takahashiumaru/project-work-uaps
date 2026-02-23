<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $table = 'stations'; // Nama tabel di database

    protected $fillable = [
        'code',      // Kode (SUB, CGK)
        'name',      // Nama (Surabaya, Jakarta)
        'is_active', // Status (1/0)
    ];
}