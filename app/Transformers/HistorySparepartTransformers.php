<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\HistorySparepart;

class HistorySparepartTransformers extends TransformerAbstract
{
    
    public function transform(HistorySparepart $history)
    {
        return [
            'id'            => $history->id,
            'id_sparepart'  => $history->id_sparepart,
            'nama'          => optional($history->spareparts)->nama,
            'tanggal'       => $history->tanggal,
            'jumlah'        => $history->jumlah,
            'satuan_harga'  => $history->satuan_harga,
            'subtotal'      => $history->subtotal,
            'status'        => $history->status,
        ];
    }
}