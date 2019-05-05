<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SparepartProcurementDetails;
use App\SparepartProcurement;
use App\HistorySparepart;
use App\Sparepart;
use App\Transformers\SparepartProcurementDetailsTransformers;

class SparepartProcurementDetailController extends RestController
{
    protected $transformer = SparepartProcurementDetailsTransformers::Class;

    public function index()
    {
        $sparepartprocurementdetail = SparepartProcurementDetails::all();
        $response = $this->generateCollection($sparepartprocurementdetail);
        return $this->sendResponse($response, 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function storeDetailProcurementAndroid(Request $request)
    {
        $detailProcurement = new SparepartProcurementDetails;
        $detailProcurement->id_sparepart = $request->id_sparepart;
        $detailProcurement->id_sparepart_procurement = $request->id_sparepart_procurement;
        $detailProcurement->jumlah = $request->jumlah;
        $detailProcurement->satuan_harga = $request->satuan_harga;
        $detailProcurement->subtotal = $request->subtotal;
        $detailProcurement->save();
        
        return response()->json(['status' => 'success','msg'=>'Procurement detail berhasil dibuat']);
    }

    public function show($id)
    {
        $detailProcurement = SparepartProcurementDetails::where('id',$id)->get()->first();
        $response = $this->generateItem($detailProcurement);
        return $this->sendResponse($response, 200);
    }

    public function showUsingIdSparepart($id)
    {
        $detailProcurement = SparepartProcurementDetails::where('id_sparepart_procurement',$id)->get();
        $response = $this->generateCollection($detailProcurement);
        return $this->sendResponse($response, 200);
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

    public function verifAndroid(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detailProcurement = SparepartProcurementDetails::findorFail($id);
        $detailProcurement->jumlah = $request->jumlah;
        $detailProcurement->satuan_harga = $request->satuan_harga;
        $detailProcurement->subtotal = $request->subtotal;
        $detailProcurement->save();
        
        $sparepart = Sparepart::findOrFail($detailProcurement->id_sparepart);
        $sparepart->stok = $sparepart->stok + $detailProcurement->jumlah;
        $sparepart->harga_beli = $detailProcurement->satuan_harga;
        $sparepart->save();
        
        $procurement = SparepartProcurement::findorFail($detailProcurement->id_sparepart_procurement);

        $history = new HistorySparepart();
        $history->id_sparepart = $detailProcurement->id_sparepart;
        $history->tanggal = $procurement->tanggal;
        $history->jumlah = $detailProcurement->jumlah;
        $history->satuan_harga = $detailProcurement->satuan_harga;
        $history->subtotal = $detailProcurement->subtotal;
        $history->status = 1;
        $history->save();

        return response()->json(['status' => 'success','msg'=>'Procurement detail berhasil diverifikasi'],201);
    }

    public function destroy($id)
    {
        //    
    }
}
