<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name', 'route_name', 'icon_class', 'order'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'menu_user');
    }
}
