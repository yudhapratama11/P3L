<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Transformers\RoleTransformers;

class RoleController extends RestController
{
    protected $transformer = RoleTransformers::Class;

    public function index()
    {
        $roles = Role::all();
        $response = $this->generateCollection($roles);
        return $this->sendResponse($response, 200);
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
        $response = $this->generateItem($role);
        return $this->sendResponse($response, 200);
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

        return response()->json(['status'=>'success','message'=>'Berhasil mengubah'],201);
    }

    public function destroy($id) // softdelete
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['status'=>'success','message'=>'Berhasil menghapus'],202);
    }
}

   
