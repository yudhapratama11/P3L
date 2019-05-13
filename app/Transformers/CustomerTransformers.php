<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Customer;

class CustomerTransformers extends TransformerAbstract
{

    protected $defaultIncludes = [
        'detail'
    ];
    
    public function transform(Customer $customer)
    {
        return [
            'id'                => $customer->id,
            'nama'              => $customer->nama,
            'nomor_telepon'     => $customer->nomor_telepon,
            'alamat'            => $customer->alamat,
        ];
    }

    public function includeDetail(Customer $customer)
    {
        return $this->collection($customer->customer_motorcycle, new CustomerMotorcycleTransformers);
    }
}