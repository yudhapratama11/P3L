<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\MotorcycleBrand;
use App\MotorcycleType;

class MotorcycleBrandTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'detail'
    ];
    
    public function transform(MotorcycleBrand $motorcyclebrand)
    {
        return [
            'id'                => $motorcyclebrand->id,
            'nama'              => $motorcyclebrand->nama,
        ];
    }

    public function includeDetail(MotorcycleBrand $motorcyclebrand)
    {
        return $this->collection($motorcyclebrand->MotorcycleType, new MotorcycleTypeTransformers);
    }

}