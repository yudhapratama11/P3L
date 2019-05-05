<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistorySparepart extends Model
{
    use SoftDeletes;
    protected $table = "history_sparepart";

    protected $fillable = [
        'id_sparepart','tanggal','jumlah','satuan_harga','subtotal','status'
    ];

    protected $dates = [
        'created_at','updated_at'
    ];

    public function spareparts(){
        return $this->belongsTo(Sparepart::class,'id_sparepart','id');
    }
    
}
