<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blacklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'fullname',
        'reason',
        'station',
        'banned_by',
    ];

}
