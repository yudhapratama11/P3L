<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MotorcycleType;
use App\Transformers\MotorcycleTypeTransformers;

class MotorcycleTypeController extends RestController
{
    protected $transformer = MotorcycleTypeTransformers::Class;

    public function index()
    {
        $motorcycletype = MotorcycleType::all();
        $response = $this->generateCollection($motorcycletype);
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
            'harga' => 'required|max:12',
          ]);

        $service = new Service();
        $service->nama = $request->nama;
        $service->harga = $request->harga;
        $service->save();    

        return response()->json(['status' => 'success','msg'=>'Service berhasil dibuat']);
    }

    public function show($id)
    {
        $service = Service::where('id',$id)->get();
        $response = $this->generateCollection($service);
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
            'harga' => 'required|max:12',
        ]);

        $service = Service::findOrFail($id);
        $service->nama = $request->nama;
        $service->harga = $request->harga;
        $service->save();

        return response()->json(['status'=>'success','message'=>'Berhasil mengubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) // softdelete
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return response()->json(['status'=>'success','message'=>'Berhasil menghapus'],202);
    }
}
