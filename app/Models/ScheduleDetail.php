<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule_detail extends Model
{
    use HasFactory;

    protected $table = 'schedule_details';

    protected $fillable = ['schedule_id', 'user_id'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
