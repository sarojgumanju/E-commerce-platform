<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'dokan_id', 'qty', 'amount'
    ];
    
    protected $casts = [
        'amount' => 'float',
        'qty' => 'integer'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function dokan()
    {
        return $this->belongsTo(Dokan::class, 'dokan_id');
    }
}