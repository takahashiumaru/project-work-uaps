<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;


    protected $table = 'schedules';
    public $timestamps = false;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['user_id', 'date', 'shift_id'];

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function freelance(): BelongsTo
    {
        return $this->belongsTo(Freelance::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the details for the schedule.
     */
    public function details(): HasMany
    {
        return $this->hasMany(ScheduleDetail::class, 'schedule_id');
    }
}
