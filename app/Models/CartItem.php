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
        'track_id',
    ];

    protected $casts = [
        'item_price' => 'float',
    ];

    public function cart(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
    public function track(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Track::class);
    }
}
