<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\SparepartProcurementDetails;
use App\SparepartProcurement;

class SparepartProcurementDetailsTransformers extends TransformerAbstract
{
    
    public function transform(SparepartProcurementDetails $procurementdetails)
    {
        return [
            'id'                => $procurementdetails->id,
            'id_sparepart'      => optional($procurementdetails->spareparts)->id,
            'nama_sparepart'    => optional($procurementdetails->spareparts)->nama,
            'jumlah'            => $procurementdetails->jumlah,
            'satuan_harga'      => $procurementdetails->satuan_harga,
            'subtotal'          => $procurementdetails->subtotal,
            'id_sparepart_procurement' => $procurementdetails->id_sparepart_procurement
        ];
    }
}