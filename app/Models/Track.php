<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class);
    }


//    public function orderItems()
//    {
//        return $this->hasMany(OrderItem::class);
//    }

    public function licences()
    {
        return $this->belongsToMany(License::class)
            ->using(ProductSize::class)
            ->withPivot('price');
    }

    public function getPrice($size)
    {
        return $this->sizes->where('id', $size)->first()->pivot->price;
    }
}
