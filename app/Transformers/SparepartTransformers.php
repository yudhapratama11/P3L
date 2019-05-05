<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sparepart_Type;
use App\Sparepart;


class SparepartTransformers extends TransformerAbstract
{
    
    public function transform(Sparepart $sparepart)
    {
        $placement = explode('-',trim($sparepart->penempatan));
        return [
            'id'                => $sparepart->id,
            'nama'              => $sparepart->nama,
            'merk'              => $sparepart->merk,
            'harga_beli'        => $sparepart->harga_beli,
            'harga_jual'        => $sparepart->harga_jual,
            'stok'              => $sparepart->stok,
            'stok_minimal'      => $sparepart->stok_minimal,
            'penempatan'        => $sparepart->penempatan,
            'posisi'            => $placement[0],
            'tempat'            => $placement[1],
            'nomor'             => $placement[2],
            'gambar'            => $sparepart->gambar,  
            'tipe_sparepart'    => optional($sparepart->sparepart_type)->nama,
        ];
    }
}