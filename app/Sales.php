<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama', 'nomor_telepon','id_supplier'
    ];

    protected $dates = [
        'created_at','deleted_at','updated_at',
    ];
    
    public function supplier(){
        return $this->belongsTo(Supplier::class,'id_supplier','id')->withTrashed();
    }

}
