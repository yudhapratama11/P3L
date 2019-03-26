<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();
        return $services;
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
        return $service;
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
    }
}
