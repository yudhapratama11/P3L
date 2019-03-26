<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branches::all();
        return $branches;
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
          
          $branches = new Branches();
          $branches->nama = $request->nama;
          $branches->alamat = $request->alamat;
          $branches->save();
    
          return response()->json(['status' => 'success','msg'=>'Cabang berhasil dibuat']);
    }

    public function show($id)
    {
        $branch = Branch::where('id',$id)->get();
        return $branch;
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
