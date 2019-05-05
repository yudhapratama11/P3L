<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sales;
use App\Supplier;

class SalesTransformers extends TransformerAbstract
{
    public function transform(Sales $sales)
    {
        return [
            'id'                => $sales->id,
            'nama'              => $sales->nama,
            'nomor_telepon'     => $sales->nomor_telepon,
            'nama_supplier'     => optional($sales->supplier)->nama,
            'id_supplier'       => optional($sales->supplier)->id,
        ];
    }
}