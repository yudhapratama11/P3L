<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTransaction extends Model
{
    protected $table = "transaction_service_details";
    use SoftDeletes;

    protected $fillable = [
        'id_transaction','id_service','id_customer_motorcycle','id_montir_onduty','status_montir_onduty','subtotal'
    ];

    protected $dates = [
        'created_at','updated_at','deleted_at'
    ];

    public function transaction(){
        return $this->belongsTo(Transaction::class,'id_transaction','id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'id_service','id');
    }
    
    public function service_transaction()
    {
        return $this->hasMany(Transaction::class,'id_service','id');
    }

    public function customer_motorcycle()
    {
        return $this->belongsTo(CustomerMotorcycle::class,'id_customer_motorcycle','id');
    }
    
    public function montir_onduty()
    {
        return $this->belongsTo(Employees::class,'id_montir_onduty','id');
    }
}
