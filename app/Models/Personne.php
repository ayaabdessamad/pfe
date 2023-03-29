<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Personne extends Authenticatable implements JWTSubject
{
    use HasFactory, HasApiTokens,  Notifiable;
    protected $table = 'personne';
    public $timestamps = false;


    protected $fillable = [
        'id',
        'nom',
        'prénom',
        'email',
        'password',
        'role',
        'statut',
        'solde',
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
