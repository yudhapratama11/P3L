<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    protected $fillable = [
        'nama', 'nomor_telepon', 'alamat', 'gaji', 'id_branch', 'id_user', 'id_roles'
    ];

    // protected $hidden = [
    // ];

    protected $dates = [
        'created_at','deleted_at'
    ];
    
}
