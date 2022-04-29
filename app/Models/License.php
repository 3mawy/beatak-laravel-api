<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    // TODO
    use HasFactory;

    protected $fillable = [
        'size',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(ProductSize::class)
            ->withPivot('price');;
    }
}
