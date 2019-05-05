<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama', 'nomor_telepon', 'alamat',
    ];

    protected $dates = [
        'created_at','deleted_at'
    ];

    public function sales(){
        return $this->hasMany(Sales::class,'id_supplier','id')->withTrashed();
    }
}
