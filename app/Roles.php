<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public function user(){
        return $this->hasMany(User::class);
    }
    
    protected $fillable = [
        'nama',
    ];

    protected $dates = [
        'created_at','deleted_at'
    ];
}
