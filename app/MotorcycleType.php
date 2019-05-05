<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotorcycleType extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nama','id_motorcycle_brands'
    ];

    public function MotorcycleBrand(){
        return $this->belongsTo(MotorcycleBrand::class,'id_motorcycle_brands','id')->withTrashed();
    }

    
}
