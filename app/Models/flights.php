<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class flights extends Model
{
    use HasFactory;

    protected $table = 'flights';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'airline',
        'flight_number',
        'registasi',
        'arrival',
        'time_count',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(Flight_details::class, 'flight_id', 'id');
    }
}
