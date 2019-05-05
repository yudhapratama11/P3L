<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Transaction;

class TransactionTransformers extends TransformerAbstract
{
    
    public function transform(Transaction $transaction)
    {
        return [
            'id'                    => $transaction->id,
            'tanggal'               => $transaction->tanggal,
            'status'                => $transaction->status,
            'status_paid'           => $transaction->status_paid,
            'id_transaction_type'   => $transaction->id_transaction_type,
            'customer'              => optional($transaction->customer)->nama,
            'id_customer'           => $transaction->id_customer,
            'discount'              => $transaction->discount,
            'subtotal'              => $transaction->subtotal,
        ];
    }
}