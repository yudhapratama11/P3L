<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\SparepartProcurement;
use App\SparepartProcurementDetails;

class SparepartProcurementTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'detail'
    ];
    
    public function transform(SparepartProcurement $sparepartprocurement)
    {
        return [
            'id'            => $sparepartprocurement->id,
            'sales'         => optional($sparepartprocurement->sales)->nama,
            'id_sales'      => $sparepartprocurement->id_sales,
            'tanggal'       => $sparepartprocurement->tanggal,
            'status'        => $sparepartprocurement->status
        ];
    }

    public function includeDetail(SparepartProcurement $sparepartprocurement)
    {
        return $this->collection($sparepartprocurement->sparepart_procurement_details, new SparepartProcurementDetailsTransformers);
    }
}