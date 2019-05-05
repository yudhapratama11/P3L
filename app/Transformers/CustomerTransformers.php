<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Customer;

class CustomerTransformers extends TransformerAbstract
{
    
    public function transform(Customer $customer)
    {
        return [
            'id'                => $customer->id,
            'nama'              => $customer->nama,
            'nomor_telepon'     => $customer->nomor_telepon,
            'alamat'            => $customer->alamat,
        ];
    }
}