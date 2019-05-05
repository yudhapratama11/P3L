<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Branch;

class BranchTransformers extends TransformerAbstract
{
    
    public function transform(Branch $branch)
    {
        return [
            'id'                => $branch->id,
            'nama'              => $branch->nama,
            'alamat'            => $branch->alamat,
        ];
    }
}