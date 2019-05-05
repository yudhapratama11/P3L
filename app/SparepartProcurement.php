<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparepartProcurement extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id_sales','tanggal','status'
    ];

    protected $dates = [
        'created_at','deleted_at','updated_at',
    ];

    public function sparepart_procurement_details(){
        return $this->hasMany(SparepartProcurementDetails::class,'id_sparepart_procurement','id');
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class,'id_sales','id')->withTrashed();
    }

}
