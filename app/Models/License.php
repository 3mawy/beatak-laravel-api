<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    // TODO
    use HasFactory;

    protected $fillable = [
        'license',
    ];

    public function tracks()
    {
        return $this->belongsToMany(Track::class)
            ->using(TrackLicense::class)
            ->withPivot('price');;
    }
}
