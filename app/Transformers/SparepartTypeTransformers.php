<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Sparepart_Type;

class SparepartTypeTransformers extends TransformerAbstract
{
    
    public function transform(Sparepart_Type $spareparttype)
    {
        return [
            'id'                => $spareparttype->id,
            'nama'              => $spareparttype->nama,
        ];
    }
}