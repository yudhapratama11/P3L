<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'nama', 'alamat'
    ];

    public function branch(){
        return $this->hasMany(Employees::class,'id');
    }

}
