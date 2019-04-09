<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sparepart extends Model
{
    public $incrementing = false;
    protected $primaryKey = "id";
    protected $table = "spareparts";
    use SoftDeletes;

    protected $fillable = [
        'id','nama','merk','harga_beli','harga_jual','stok','stok_minimal','penempatan','gambar','id_sparepart_type'
    ];

    // protected $hidden = [
    // ];

    protected $dates = [
        'created_at'
    ];

    // protected $hidden = [
    //     'created_at','updated_at'
    // ];

    public function sparepart_type(){
        return $this->belongsTo(Sparepart_Type::class,'id_sparepart_type','id');
    }
    
}
