<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const Admin = 1;
    const Kasir = 2;
    const Customer_Service = 3;
    const Montir = 4;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
    'nama',];
    
    public function role(){
        return $this->hasMany(Employees::class,'id_roles','id');
    }
}
