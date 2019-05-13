<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\SparepartTransaction;

class SparepartTransactionTransformers extends TransformerAbstract
{
    
    public function transform(SparepartTransaction $spareparttransaction)
    {
        return [
            'id'                    => $spareparttransaction->id,
            'id_transaction'        => $spareparttransaction->id_transaction,
            'id_sparepart'          => $spareparttransaction->id_sparepart,
            'nama_sparepart'        => optional($spareparttransaction->sparepart)->nama,
            'jumlah'                => $spareparttransaction->jumlah,
            'harga_satuan'          => $spareparttransaction->harga_satuan,
            'subtotal'              => $spareparttransaction->subtotal,
        ];
    }
}