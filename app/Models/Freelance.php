<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelance extends Model
{
    use HasFactory;

    // Tabel yang dipakai
    protected $table = 'freelances';

    // Kolom yang bisa diisi (mass assignment)
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'join_date',
        'active',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'user_id');
    }
}
