<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public function plats()
    {
        return $this->belongsToMany(Plat::class);
    }
    use HasFactory;


    use HasFactory;
    protected $table = 'menu';
    public $timestamps = false;
    protected $fillable = [];
}
