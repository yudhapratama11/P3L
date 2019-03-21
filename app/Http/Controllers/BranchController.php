<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branches;

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
}
