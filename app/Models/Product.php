<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $casts = [
        "images" => "array",
    ];

    public function dokan(){
        return $this->belongsTo(Dokan::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
