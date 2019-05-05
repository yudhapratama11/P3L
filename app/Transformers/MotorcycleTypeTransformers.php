<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\MotorcycleType;

class MotorcycleTypeTransformers extends TransformerAbstract
{
    public function transform(MotorcycleType $motorcycletype)
    {
        return [
            'id'        => $motorcycletype->id,
            'nama'      => $motorcycletype->nama,
            'merk'      => optional($motorcycletype->MotorcycleBrand)->nama,         
        ];
    }


}