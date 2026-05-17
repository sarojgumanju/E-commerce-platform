<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function product(){
        return $this->belongsTo(Cart::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function dokan(){
        return $this->belongsTo(Dokan::class);
    }
}
