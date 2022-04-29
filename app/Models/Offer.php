<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'active',
        'max_items',
    ];


    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function tracks()
    {
        return $this->belongsToMany(Track::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
