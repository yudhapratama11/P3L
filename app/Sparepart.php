<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    public $incrementing = false;
    
    protected $fillable = [
        'id','nama','merk','harga_beli','harga_jual','stok','stok_minimal','penempatan','gambar'
    ];

    // protected $hidden = [
    // ];

    protected $dates = [
        'created_at'
    ];
    
}
