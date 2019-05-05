<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sparepart_Type;
use App\Transformers\SparepartTypeTransformers;

class SparepartTypeController extends RestController
{
    protected $transformer = SparepartTypeTransformers::Class;
    
    public function index()
    {
        $spareparttype = Sparepart_Type::all();
        $response = $this->generateCollection($spareparttype);
        return $this->sendResponse($response, 201);
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
        ]);

        $spareparttype = new Sparepart_Type();
        $spareparttype->nama = $request->nama;
        $spareparttype->save();

        return response()->json(['status' => 'success','msg'=>'Tipe Sparepart berhasil dibuat']);
    }

    public function show($id)
    {
        $spareparttype = Sparepart_Type::where('id',$id)->get();
        $response = $this->generateCollection($spareparttype);
        return $this->sendResponse($response, 201);
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
        ]);

        $spareparttype = Sparepart_Type::findOrFail($id);
        $spareparttype->nama = $request->nama;
        $spareparttype->save();

        return response()->json(['status' => 'success','msg'=>'Berhasil mengedit Tipe Sparepart']);
    }

    public function destroy($id) // softdelete
    {
        $spareparttype = Sparepart_Type::findOrFail($id);
        $spareparttype->delete();

    	return response()->json(['status' => 'success','msg'=>'Berhasil menghapus'],202);
    }
}
