<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'check_in_time',
        'check_out_time',
        'check_in_ip',
        'check_out_ip',
        'check_in_latitude',
        'check_in_longitude',
        'check_out_latitude',
        'check_out_longitude',
        'check_in_notes',
        'check_out_notes',
        'check_in_photo',
        'check_out_photo',
    ];

    /**
     * Define relationship with User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
