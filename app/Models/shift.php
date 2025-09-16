<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'description', 'start_time', 'end_time', 'use_manpower'];

    public $incrementing = false;
    protected $keyType = 'string';
}
