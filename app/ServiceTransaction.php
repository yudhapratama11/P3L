<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceTransaction extends Model
{
    protected $table = "transaction_service_details";
    use SoftDeletes;

    protected $fillable = [
        'id_transaction','id_sparepart','id_customer_motorcycle','id_montir_onduty','status_montir_onduty','subtotal'
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
}
