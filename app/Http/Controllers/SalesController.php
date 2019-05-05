<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sales;
use App\Transformers\SalesTransformers;

class SalesController extends RestController
{
    protected $transformer = SalesTransformers::Class;
    

    public function index()
    {
        $sales = Sales::all();
        $response = $this->generateCollection($sales);
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
        $this->validateWith([
            'nama' => 'required|max:255',
            'nomor_telepon' => 'required|max:13',
            'id_supplier' => 'required|max:2',
          ]);
        $sales = new Sales();
        $sales->nama = $request->nama;
        $sales->nomor_telepon = $request->nomor_telepon;
        $sales->id_supplier = $request->id_supplier;
        $sales->save();    

        return response()->json(['status' => 'success','msg'=>'Sales berhasil dibuat'],201);
    }

    public function show($id)
    {
        $sales = Sales::where('id',$id)->get();
        $response = $this->generateCollection($sales);
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

    public function update(Request $request, $id)
    {
        $this->validateWith([
            'nama' => 'required|max:255',
            'nomor_telepon' => 'required|max:13',
        ]);

        $sales = Sales::findOrFail($id);
        $sales->nama = $request->nama;
        $sales->nomor_telepon = $request->nomor_telepon;
        $sales->id_supplier = $request->id_supplier;
        $sales->save();

        return response()->json(['status'=>'success','message'=>'Berhasil mengubah'],201);
    }

    public function destroy($id)
    {
        $sales = Sales::findOrFail($id);
        $sales->delete();

        return response()->json(['status'=>'success','message'=>'Berhasil menghapus'],202);
    }
}
