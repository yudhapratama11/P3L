<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Service;

class ServiceTransformers extends TransformerAbstract
{
    
    public function transform(Service $service)
    {
        return [
            'id'        => $service->id,
            'nama'      => $service->nama,
            'harga'     => $service->harga,
        ];
    }
}