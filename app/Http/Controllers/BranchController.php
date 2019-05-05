<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Transformers\BranchTransformers;

class BranchController extends RestController
{
    protected $transformer = BranchTransformers::Class;

    public function index()
    {
        $branches = Branch::all();
        $response = $this->generateCollection($branches);
        return $this->sendResponse($response, 200);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateWith([
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
          ]);
          
          $branches = new Branch();
          $branches->nama = $request->nama;
          $branches->alamat = $request->alamat;
          $branches->nomor_telepon = $request->nomor_telepon;
          $branches->save();
    
          return response()->json(['status' => 'success','msg'=>'Cabang berhasil dibuat']);
    }

    public function show($id)
    {
        $branch = Branch::where('id',$id)->get();
        $response = $this->generateCollection($branch);
        return $this->sendResponse($response, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
        ]);
        
        $branch = Branch::findOrFail($id);
        $branch->nama = $request->nama;
        $branch->alamat = $request->alamat;
        $branch->nomor_telepon = $request->nomor_telepon;
        $branch->save();
         
        return response()->json(['status' => 'success','message'=>'Berhasil mengubah']);
    }

    public function destroy($id) // softdelete
    {
        $Branch = Branch::findOrFail($id);
        $Branch->delete();
        
       return response()->json(['status' => 'success','msg'=>'Berhasil menghapus']);
    }
}
