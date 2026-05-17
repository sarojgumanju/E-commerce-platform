<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Hidden;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Hidden(['password', 'remember_token'])]

class Admin extends Authenticatable{

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

