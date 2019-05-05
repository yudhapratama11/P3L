<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Transformers\CustomerTransformers;

class CustomerController extends RestController
{
    protected $transformer = CustomerTransformers::Class;

    public function index()
    {
        $customer = Customer::all();
        $response = $this->generateCollection($customer);
        return $this->sendResponse($response, 200);
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
        $this->validateWith([
            'nama' => 'required|max:50',
            'nomor_telepon' => 'required|max:13',
            'alamat' => 'required|max:100',
          ]);

        $customer = new Customer();
        $customer->nama = $request->nama;
        $customer->nomor_telepon = $request->nomor_telepon;
        $customer->alamat = $request->alamat;
        $customer->save();    

        return response()->json(['status' => 'success','msg'=>'Customer berhasil dibuat'],201);
    }

    public function show($id)
    {
        $customer = Customer::where('id',$id)->get()->first();
        $response = $this->generateItem($customer);
        return $this->sendResponse($response, 200);
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
        $this->validateWith([
            'nama' => 'required|max:50',
            'nomor_telepon' => 'required|max:13',
            'alamat' => 'required|max:100',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->nama = $request->nama;
        $customer->nomor_telepon = $request->nomor_telepon;
        $customer->alamat = $request->alamat;
        $customer->save();    

        return response()->json(['status' => 'success','msg'=>'Berhasil mengubah'],201);
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(['status'=>'success','message'=>'Berhasil menghapus'],202);
    }
}
