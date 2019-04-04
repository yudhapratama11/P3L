<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sparepart;
use \File;
use App\Transformers\SparepartTransformers;

class SparepartController extends RestController
{
    protected $transformer = SparepartTransformers::Class;
    
    public function __construct()
    {
        parent::__construct();
        $this->photos_path = public_path('/itemImages');
    }
    
    public function index()
    {
        //return response()->json(Sparepart::all());
        $userdata = Sparepart::get();
        //sreturn $userdata;
        $response = $this->generateCollection($userdata);
        return $this->sendResponse($response, 201);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'nama' => 'required',
            'merk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'stok_minimal' => 'required',
            'id_sparepart_type' => 'required',
            'penempatan' => 'required',
            'gambar' => 'required',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $sparepart = new Sparepart();
        $sparepart->id = $request->id;
        $sparepart->nama = $request->nama;
        $sparepart->merk = $request->merk;
        $sparepart->harga_beli = $request->harga_beli;
        $sparepart->harga_jual = $request->harga_jual;
        $sparepart->stok = $request->stok;
        $sparepart->stok_minimal = $request->stok_minimal;
        $sparepart->id_sparepart_type = $request->id_sparepart_type;
        $sparepart->penempatan = $request->penempatan;
        
        if($request->hasfile('gambar'))
        {
            $image = $request->file('gambar');
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $image->getClientOriginalExtension();
            $image->move($this->photos_path, $save_name);  
            $sparepart->gambar=$save_name;
        }

        $sparepart->save();
        
        //return $sparepart;
        $response = $this->generateItem($sparepart);
        return $this->sendResponse($response, 201);
    }

    public function show($id)
    {
        return Sparepart::where([['id',$id]])->first();
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'merk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'stok_minimal' => 'required',
            'penempatan' => 'required',
            'gambar' => 'required',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->nama = $request->nama;
        $sparepart->merk = $request->merk;
        $sparepart->harga_beli = $request->harga_beli;
        $sparepart->harga_jual = $request->harga_jual;
        $sparepart->stok = $request->stok;
        $sparepart->stok_minimal = $request->stok_minimal;
        $sparepart->penempatan = $request->penempatan;

        if($request->hasfile('gambar'))
        {
            $gambarlama = $this->photos_path . '/' . $sparepart->gambar;
            if (file_exists($gambarlama)) {
                unlink($gambarlama);
            }
            $image = $request->file('gambar');
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $image->getClientOriginalExtension();
            $image->move($this->photos_path, $save_name);  
            $sparepart->gambar=$save_name;
        }
        $sparepart->save();
        return response()->json(['status'=>'success','message' => 'Update sparepart sukses'], 400);
    }

    public function destroy($id) //SoftDelete
    {
        //
    }
}
