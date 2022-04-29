<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSize extends Pivot
{
    use HasFactory;
    protected $fillable = [
        'price',
    ];
    protected $table = "product_size";
    public $incrementing = true;
    public $timestamps = false;

//    protected $hidden = [
//        'product_id',
//        'size_id',
//    ];

}
