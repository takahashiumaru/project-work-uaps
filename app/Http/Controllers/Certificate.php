<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates';

    protected $fillable = [
        'user_id',
        'certificate_name',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRemainingDaysAttribute()
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function getIsExpiringAttribute()
    {
        return $this->remaining_days <= 30 && $this->remaining_days >= 0;
    }
}