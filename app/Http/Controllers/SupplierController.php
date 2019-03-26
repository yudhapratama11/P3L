<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return $supplier;
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
        $this->validate($request, [
            'nama' => 'required|max:255',
            'nomor_telepon' => 'required|max:255',
            'alamat' => 'required|max:255',
        ]);

        $supplier = new Supplier();
        $supplier->nama = $request->nama;
        $supplier->nomor_telepon = $request->nomor_telepon;
        $supplier->alamat = $request->alamat;
        $supplier->save();

        return response()->json(['status' => 'success','msg'=>'Supplier berhasil dibuat']);
    }

    public function show($id)
    {
        $supplier = Supplier::where('id',$id)->get();
        return $supplier;
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
        $this->validate($request, [
            'nama' => 'required|max:100',
            'nomor_telepon' => 'required|max:13',
            'alamat' => 'required|max:100',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->nama = $request->nama;
        $supplier->nomor_telepon = $request->nomor_telepon;
        $supplier->alamat = $request->alamat;
        $supplier->save();

        return response()->json(['status' => 'success','msg'=>'Berhasil mengedit supplier']);
    }

    public function destroy($id) // softdelete
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

    	return response()->json(['status' => 'success','msg'=>'Berhasil menghapus supplier']);
    }
}