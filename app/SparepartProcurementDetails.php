<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparepartProcurementDetails extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_sparepart', 'id_sparepart_procurement','jumlah','satuan_harga','subtotal','status'
    ];

    protected $dates = [
        'created_at','deleted_at','updated_at',
    ];
    
    public function sparepart_procurement(){
        return $this->belongsTo(Supplier::class,'id_supplier','id')->withTrashed();
    }

    public function spareparts(){
        return $this->belongsTo(Sparepart::class,'id_sparepart','id');
    }
}
