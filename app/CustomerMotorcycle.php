<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CustomerMotorcycle extends Model
{
    protected $table = "customers_motorcycle";
    use SoftDeletes;

    protected $fillable = [
        'plat','id_motorcycle_type'
    ];

    protected $dates = [
        'created_at','updated_at','deleted_at'
    ];

    public function motorcycle_type(){
        return $this->belongsTo(MotorcycleType::class,'id_motorcycle_type','id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class,'id_customer','id')->withTrashed();
    }

}
