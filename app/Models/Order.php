<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function dishes()
    {
        return $this->belongsToMany('App\Models\Dish');
    }
}
