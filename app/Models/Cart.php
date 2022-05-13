<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_price',
        'user_id'
    ];

    protected $casts = [
        'total_price' => 'float',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cartItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartItem::class);
    }

}
