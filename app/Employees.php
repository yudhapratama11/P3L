<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    protected $fillable = [
        'nama', 'nomor_telepon', 'alamat', 'gaji', 'id_branch', 'id_user'
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'created_at','deleted_at'
    ];
    
}
