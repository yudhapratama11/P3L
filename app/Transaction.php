<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    public $incrementing = false;
    protected $primaryKey = "id";
    protected $table = "transactions";
    
    protected $fillable = [
        'id','tanggal','status','status_paid','id_transaction_type','id_customer','discount','subtotal'
    ];

    protected $dates = [
        'created_at','updated_at','deleted_at'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class,'id_customer','id')->withTrashed();
    }

    public function sparepart_transaction(){
        return $this->hasMany(SparepartTransaction::class,'id_transaction','id');
    }

    public function service_transaction(){
        return $this->hasMany(ServiceTransaction::class,'id_transaction','id');
    }
    public function employees_onduty(){
        return $this->belongsToMany(Employees::class,'employee_onduties','id_transaction','id_employee');
    }
}
