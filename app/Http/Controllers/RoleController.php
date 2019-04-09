<?php

namespace App\Http\Controllers;
use App\Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return $roles;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validateWith([
            'nama' => 'required|max:255',
          ]);

        $role = new Role();
        $role->nama = $request->nama;
        $role->save();    

        return response()->json(['status' => 'success','msg'=>'Role berhasil dibuat']);
    }

    public function show($id)
    {
        $role = Role::where('id',$id)->get();
        return $role;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id) //update dari panel admin
    {
        $this->validateWith([
            'nama' => 'required|max:255',
        ]);

        $role = Service::findOrFail($id);
        $role->nama = $request->nama;
        $role->save();

        return response()->json(['status'=>'success','message'=>'Berhasil mengubah']);
    }

    public function destroy($id) // softdelete
    {
        $service = Service::findOrFail($id);
        $service->delete();
    }
}
