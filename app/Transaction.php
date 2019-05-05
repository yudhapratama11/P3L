<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $incrementing = false;
    protected $primaryKey = "id";
    protected $table = "transactions";
    use SoftDeletes;

    protected $fillable = [
        'id','tanggal','status','status_paid','id_transaction_type','id_customer','discount','subtotal'
    ];

    protected $dates = [
        'created_at','updated_at','deleted_at'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class,'id_customer','id');
    }
}
