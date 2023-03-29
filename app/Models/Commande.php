<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $table = 'commande';

    public $timestamps = false;
    protected $fillable = [
        'id',
        'quantite',
        'prix',
        'id_plat',
        'id_client',

    ];
}
