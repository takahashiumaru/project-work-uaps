<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule extends Model
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

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function freelance()
    {
        return $this->belongsTo(Freelance::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
