<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    // TODO
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'item_price',
        'license_id',
        'product_id',
    ];

    protected $casts = [
        'item_price' => 'float',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

}
