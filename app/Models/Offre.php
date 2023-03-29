<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    protected $primaryKey = 'id_offre';

    use HasFactory;
    protected $table = 'offres';
    public $timestamps = false;
    protected $fillable = [


        'nom',
        'id_service'

    ];
}
