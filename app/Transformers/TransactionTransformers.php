<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transaction;

class TransactionTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'sparepart',
        'service',
        'employeeonduty'
    ];
    
    public function transform(Transaction $transaction)
    {
        return [
            'id'                    => $transaction->id,
            'tanggal'               => $transaction->tanggal,
            'status'                => $transaction->status,
            'status_paid'           => $transaction->status_paid,
            'id_transaction_type'   => $transaction->id_transaction_type,
            'customer'              => optional($transaction->customer)->nama,
            'nomor_telepon'         => optional($transaction->customer)->nomor_telepon,
            'alamat'                => optional($transaction->customer)->alamat,
            'id_customer'           => $transaction->id_customer,
            'discount'              => $transaction->discount,
            'subtotal'              => $transaction->subtotal,
        ];
    }

    public function includeSparepart(Transaction $transaction)
    {
        return $this->collection($transaction->sparepart_transaction, new SparepartTransactionTransformers);
    }

    public function includeService(Transaction $transaction)
    {
        return $this->collection($transaction->service_transaction, new ServiceTransactionTransformers);
    }

    public function includeEmployeeOnDuty(Transaction $transaction)
    {
        return $this->collection($transaction->employees_onduty, new EmployeeTransformers);
    }
}