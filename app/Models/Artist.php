<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Artist extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tracks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
