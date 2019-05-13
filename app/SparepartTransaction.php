<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparepartTransaction extends Model
{
    protected $table = "transaction_sparepart_details";
    use SoftDeletes;

    protected $fillable = [
        'id_sparepart','jumlah','harga_satuan','subtotal'
    ];

    protected $dates = [
        'created_at','updated_at','deleted_at'
    ];

    public function transaction(){
        return $this->belongsTo(Transaction::class,'id_transaction','id');
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class,'id_sparepart','id');
    }



}
