<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama', 'alamat', 'nomor_telepon'
    ];

    public function branch(){
        return $this->hasMany(Employees::class,'id_branch','id');
    }
}
