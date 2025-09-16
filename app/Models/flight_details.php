<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class flight_details extends Model
{
    use HasFactory;

    protected $table = 'flight_details';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'flight_id',
        'schedule_id',
        'created_at',
        'updated_at'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
