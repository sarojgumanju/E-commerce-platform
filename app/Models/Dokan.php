<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Hidden(['password', 'remember_token'])]

class Dokan extends Authenticatable
{

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

}
