<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerMotorcycle;
use App\Transformers\CustomerMotorcycleTransformers;

class CustomerMotorcycleController extends RestController
{
    protected $transformer = CustomerMotorcycleTransformers::class;

    public function index()
    {
        $customermotorcycle = CustomerMotorcycle::all();
        $response = $this->generateCollection($customermotorcycle);
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
            'plat' => 'required|max:15',
            'id_customer' => 'required',
            'id_motorcycle_type' => 'required',
          ]);

        $customermotorcycle = new CustomerMotorcycle();
        $customermotorcycle->plat = $request->plat;
        $customermotorcycle->id_customer = $request->id_customer;
        $customermotorcycle->id_motorcycle_type = $request->id_motorcycle_type;
        $customermotorcycle->save();    

        return response()->json(['status' => 'success','msg'=>'Customer Motorcycle berhasil dibuat'],201);
    }

    public function show ($id)
    {
        $customermotorcycle = CustomerMotorcycle::where('id',$id)->get();
        $response = $this->generateCollection($customermotorcycle);
        return $this->sendResponse($response, 200);
    }

    public function getMotorcycleByIdCustomer($id)
    {
        $customermotorcycle = CustomerMotorcycle::where('id_customer',$id)->get();
        $response = $this->generateCollection($customermotorcycle);
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
            'plat' => 'required|max:15',
            'id_customer' => 'required',
            'id_motorcycle_type' => 'required',
          ]);
        $customermotorcycle = CustomerMotorcycle::findOrFail($id);
        $customermotorcycle->plat = $request->plat;
        $customermotorcycle->id_customer = $request->id_customer;
        $customermotorcycle->id_motorcycle_type = $request->id_motorcycle_type;
        $customermotorcycle->save();  

        return response()->json(['status' => 'success','msg'=>'Customer Motorcycle berhasil diedit'],201);
    }

    public function destroy($id)
    {
        $customer = CustomerMotorcycle::findOrFail($id);
        $customer->delete();

        return response()->json(['status'=>'success','message'=>'Berhasil menghapus'],202);
    }
}
