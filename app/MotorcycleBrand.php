<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotorcycleBrand extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nama'
    ];

    public function MotorcycleType(){
        return $this->hasMany(MotorcycleType::class,'id_motorcycle_brands','id');
    }
}
