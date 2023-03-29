<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model

{
    /* public function hotels()
    {
        return $this->belongsToMany(Hotel::class, 'hotels_services', 'services_id', 'hotels_id');
    }*/
    /* public function hotels()
    {
        return $this->belongsTo(Hotel::class);
    }*/
    protected $primaryKey = 'id_service';

    use HasFactory;
    protected $table = 'services';
    public $timestamps = false;
    protected $fillable = [

        'nom',
        'description',
        'image',
        'type'



    ];
}
