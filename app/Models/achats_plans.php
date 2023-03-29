<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class achats_plans extends Model
{
    use HasFactory;
    protected $table = 'achats_plans';

    public $timestamps = false;
    protected $fillable = [
        'id',

        'montant_paye',
        'id_plan',
        'id_client',

    ];
}
