<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\ServiceTransaction;

class ServiceTransactionTransformers extends TransformerAbstract
{
    
    public function transform(ServiceTransaction $servicetransaction)
    {
        return [
            'id'                    => $servicetransaction->id,
            'id_transaction'        => $servicetransaction->id_transaction,
            'id_service'            => $servicetransaction->id_service,
            'service'               => optional($servicetransaction->service)->nama,
            'id_customer_motorcycle'=> $servicetransaction->id_customer_motorcycle,
            'customer_motorcycle'   => optional($servicetransaction->customer_motorcycle)->plat,
            'id_montir_onduty'      => $servicetransaction->id_montir_onduty,
            'montir_onduty'         => optional($servicetransaction->montir_onduty)->nama,
            'status_montir_onduty'  => $servicetransaction->status_montir_onduty,
            'subtotal'              => $servicetransaction->subtotal,
        ];
    }
}