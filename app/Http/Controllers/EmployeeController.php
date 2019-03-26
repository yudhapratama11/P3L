<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employees;
use App\User;

class EmployeeController extends Controller
{

    public function index()
    {
        $employees = Employees::all();
        return $employees;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $employees = Employees::where('id',$id)->get();
        return $employees;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id) //update dari panel admin
    {
        $this->validate($request, [
            'nama' => 'required|max:60',
            'nomor_telepon' => 'max:13',
            'password' => 'max:15',
            'alamat' => 'max:100',
            'gaji' => 'max:12',
            'id_branch' => 'required|max:1',
            'id_roles' => 'required|max:1'
        ]);
        
        $employees = Employees::findOrFail($id);
        $employees->nama = $request->nama;
        $employees->nomor_telepon = $request->nomor_telepon;
        $employees->alamat = $request->alamat;
        $employees->gaji = $request->gaji;
        $employees->id_branch = $request->$id_branch;
        $employees->id_roles = $request->$id_roles;
        $employees->save();
         
        return response()->json(['status' => 'success','msg'=>'Berhasil mengubah']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $employees = Employees::findOrFail($id);
        $employees->delete();
        
        $user = User::findOrFail($employees->id_user);
        $user->delete();

    	return response()->json(['status' => 'success','msg'=>'Berhasil menghapus']);
    }
}
