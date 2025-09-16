<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'safety_management_system',
        'human_factors',
        'ramp_safety_airside_safety',
        'dangerous_goods_regulations',
        'aviation_security_awareness',
        'airport_emergency_plan',
        'ground_support_equipment_operation',
        'basic_first_aid',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    const EXPIRING_SOON_THRESHOLD_DAYS = 30;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->end_date->isPast();
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        return !$this->is_expired && $this->remaining_days <= self::EXPIRING_SOON_THRESHOLD_DAYS;
    }

    public function getRemainingDaysAttribute(): int
    {
        if ($this->end_date->isPast()) {
            return 0;
        }
        return $this->end_date->diffInDays(now());
    }

    public function getStatusAttribute(): string
    {
        if ($this->is_expired) {
            return 'Kadaluarsa';
        } elseif ($this->is_expiring_soon) {
            return 'Akan Kadaluarsa';
        } else {
            return 'Aktif';
        }
    }
}
