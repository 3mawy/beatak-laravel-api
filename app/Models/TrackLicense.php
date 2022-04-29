<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TrackLicense extends Pivot
{
    use HasFactory;
    protected $fillable = ['price',];
    protected $table = "track_license";
    public $incrementing = true;
    public $timestamps = false;

}
