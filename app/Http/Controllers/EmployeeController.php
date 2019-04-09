<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employees;
use App\User;
use App\Transformers\EmployeeTransformers;
use App\Branch;

class EmployeeController extends RestController
{
    protected $transformer = EmployeeTransformers::Class;
    public function index()
    {
        $employees = Employees::get()->where('id_roles','!=','1');
        //return $employees;
        $response = $this->generateCollection($employees);
        return $this->sendResponse($response, 201);
        
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
        $employees->id_roles = $request->id_roles;
        $employees->id_branch = $request->id_branch;
        $employees->gaji = $request->gaji;
        
        $employees->save();
        return response()->json(['status' => 'success','message'=>'Berhasil mengubah']);

    }

    public function destroy($id) // softdelete
    {
        $employees = Employees::findOrFail($id);
        $employees->delete();
        
        $user = User::findOrFail($employees->id_user);
        $user->delete();

    	return response()->json(['status' => 'success','msg'=>'Berhasil menghapus']);
    }
}
