<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AdminHotel extends Model implements JWTSubject
{
    protected $table = 'admin_hotel';
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'nom',
        'prénom',
        'email',
        'password',
        'id_hotel'
    ];
    protected $hidden = [
        'password'
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
