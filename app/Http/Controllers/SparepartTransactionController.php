<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SparepartTransaction;

class SparepartTransactionController extends RestController
{
    protected $transformer = SparepartTransactionTransformers::Class;

    public function index()
    {
        $spareparttransaction = SparepartTransaction::all();
        $response = $this->generateCollection($spareparttransaction);
        return $this->sendResponse($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $spareparttransaction = new SparepartTransaction();
        $spareparttransaction->id_transaction = $request->id_transaction;
        $spareparttransaction->id_sparepart = $request->id_sparepart;
        $spareparttransaction->jumlah = $request->jumlah;
        $spareparttransaction->harga_satuan = $request->harga_satuan;
        $spareparttransaction->subtotal = $request->subtotal;
        $servicetransaction->save();
        
        return response()->json(['status' => 'success','msg'=>'Transaction detail service berhasil dibuat']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
