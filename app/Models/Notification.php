<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'type',
        'data',
        'read_at',
        'user_id',
        'notifiable_id',
        'notifiable_type',
        'created_at',
        'updated_at',
    ];
    protected $attributes = [
        'user_id' => 0, // ajouter la valeur par défaut ici
    ];
}
