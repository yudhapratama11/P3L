<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sparepart_Type extends Model
{
    use SoftDeletes;
    
    protected $table = "sparepart_types";

    protected $fillable = [
        'nama'
    ];

    public function sparepart(){
        return $this->hasMany(Sparepart::class,'id_sparepart_type','id');
    }

    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

}
