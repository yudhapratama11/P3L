<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employees extends Model
{
    use SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class,'id');
    }
    
    protected $fillable = [
        'nama', 'nomor_telepon', 'alamat', 'gaji', 'id_branch', 'id_user', 'id_roles'
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'created_at','deleted_at'
    ];
    
    public function role(){
    return $this->hasOne(Role::class,'id','id_roles');
    }

    public function branch(){
        return $this->hasOne(Branch::class,'id','id_branch')->withTrashed();
    }
}
