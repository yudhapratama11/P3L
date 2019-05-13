<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceTransaction;
use App\Transformers\ServiceTransactionTransformers;

class ServiceTransactionController extends RestController
{
    protected $transformer = ServiceTransactionTransformers::class;
    
    public function index()
    {
        $transactions = ServiceTransaction::all();
        $response = $this->generateCollection($transactions);
        return $this->sendResponse($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function storeAndroid(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $servicetransaction = new ServiceTransaction();
        $servicetransaction->id_transaction = $request->id_transaction;
        $servicetransaction->id_service = $request->id_service;
        $servicetransaction->id_customer_motorcycle = $request->id_customer_motorcycle;
        $servicetransaction->id_montir_onduty = $request->id_montir_onduty;
        $servicetransaction->status_montir_onduty = $request->status_montir_onduty;
        $servicetransaction->subtotal = $request->subtotal;
        $servicetransaction->save();
        
        return response()->json(['status' => 'success','msg'=>'Transaction detail sparepart berhasil dibuat'],201);
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
