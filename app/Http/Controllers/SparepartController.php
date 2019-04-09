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
        $sparepart = Sparepart::orderBy('nama','asc')->get();
        //sreturn $userdata;
        $response = $this->generateCollection($sparepart);
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

    public function updateSparepart(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'merk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'stok_minimal' => 'required',
            'penempatan' => 'required',
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

            //punya agung
            // $file = $request->file('gambar');
            // $name=time().$file->getClientOriginalName();
            // $file->move(public_path().'/itemImages/', $name);
            // $sparepart->gambar=$name;
        }
        $sparepart->save();
        return response()->json(['status'=>'success','message' => 'Update sparepart sukses'], 200);
    }
    
    public function updateSparepartAndroid(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'merk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'stok_minimal' => 'required',
            'penempatan' => 'required',
        ]);
        
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->nama = $request->nama;
        $sparepart->merk = $request->merk;
        $sparepart->harga_beli = $request->harga_beli;
        $sparepart->harga_jual = $request->harga_jual;
        $sparepart->stok = $request->stok;
        $sparepart->stok_minimal = $request->stok_minimal;
        $sparepart->penempatan = $request->penempatan;

        $sparepart->save();
        return response()->json(['status'=>'success','message' => 'Update sparepart sukses'], 201);
    }

    public function updateSparepartAndroidPicture(Request $request)
    {
        $this->validate($request, [
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $sparepart = Sparepart::findOrFail($request->id);

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

            //punya agung
            // $file = $request->file('gambar');
            // $name=time().$file->getClientOriginalName();
            // $file->move(public_path().'/itemImages/', $name);
            // $sparepart->gambar=$name;
        }
        $sparepart->save();
        return response()->json(['status'=>'success','message' => 'Update sparepart sukses'], 201);
    }

    public function destroy($id) //SoftDelete
    {
        $employees = Sparepart::findOrFail($id);
        $employees->delete();

    	return response()->json(['status' => 'success','message'=>'Berhasil menghapus'],200);
    }

    public function checkSparepartStock()
    {
        $sparepart = Sparepart::whereRaw('stok_minimal > stok')->get();
        //sreturn $userdata;
        $response = $this->generateCollection($sparepart);
        return $this->sendResponse($response, 201);
    }
}
