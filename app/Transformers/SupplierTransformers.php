<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Supplier;
use App\Sales;


class SupplierTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'detail'
    ];

    public function transform(Supplier $supplier)
    {
        return [
            'id'                => $supplier->id,
            'nama'              => $supplier->nama,
            'nomor_telepon'     => $supplier->nomor_telepon,
            'alamat'            => $supplier->alamat,
        ];
    }

    public function includeDetail(Supplier $supplier)
    {
        return $this->collection($supplier->sales, new SalesTransformers);
    }
}