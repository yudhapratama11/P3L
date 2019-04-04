<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sparepart_Type extends Model
{
    use SoftDeletes;
    
    protected $table = "sparepart_types";

    public function sparepart(){
        return $this->hasMany(Sparepart::class,'id_sparepart_type','id');
    }

}
