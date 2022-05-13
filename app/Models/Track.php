<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{

    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'active',
        'discount',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function artist(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function genre(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function cartItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartItem::class);
    }


//    public function orderItems()
//    {
//        return $this->hasMany(OrderItem::class);
//    }

    public function licenses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(License::class)
            ->using(TrackLicense::class)
            ->withPivot('price');
    }
    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function getPrice($license)
    {
        return $this->licenses->where('id', $license)->first()->pivot->price;
    }
}
