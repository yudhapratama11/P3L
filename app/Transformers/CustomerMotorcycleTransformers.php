<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\CustomerMotorcycle;

class CustomerMotorcycleTransformers extends TransformerAbstract
{
    
    public function transform(CustomerMotorcycle $customermotorcycle)
    {
        return [
            'id'                    => $customermotorcycle->id,
            'plat'                  => $customermotorcycle->plat,
            'id_motorcycle_type'    => $customermotorcycle->id_motorcycle_type,
            'motorcycle_type'       => optional($customermotorcycle->motorcycle_type)->nama,
            'id_motorcycle_brand'   => optional(optional($customermotorcycle->motorcycle_type)->MotorcycleBrand)->id,
            'motorcycle_brand'      => optional(optional($customermotorcycle->motorcycle_type)->MotorcycleBrand)->nama,
            'id_customer'           => $customermotorcycle->id_customer,
            'nama_customer'         => optional($customermotorcycle->customer)->nama
        ];
    }
}