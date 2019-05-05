<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SparepartProcurement;
use App\SparepartProcurementDetails;
use App\Transformers\SparepartProcurementTransformers;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SparepartProcurementController extends RestController
{
    protected $transformer = SparepartProcurementTransformers::Class;

    public function index()
    {
        $sparepartprocurement = SparepartProcurement::all();
        $response = $this->generateCollection($sparepartprocurement);
        return $this->sendResponse($response, 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {

            date_default_timezone_set('Asia/Jakarta');
            //return $request->detail;
            $detail = $request->get('detail');
            $procurement = new SparepartProcurement;

            $procurement->tanggal=$request->get('tanggal').' '.date('Y-m-d H:i:s');
            $procurement->status=0;
            $procurement->id_sales=$request->get('id_sales');
            $procurement->save();

            $procurement = DB::transaction(function () use ($procurement,$detail) {
                $procurement->sparepart_procurement_details()->createMany($detail);
                return $procurement;
            });
            
            
            $response = $this->generateItem($procurement);

            
            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function storeProcurementAndroid(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $detail = $request->get('detail');
        $procurement = new SparepartProcurement;
        
        $procurement->tanggal=$request->get('tanggal').' '.date('Y-m-d H:i:s');
        $procurement->status=0;
        $procurement->id_sales=$request->get('id_sales');
        $procurement->save();
        return response()->json(['message'=>$procurement->id], 201); 
    }

    public function storeProcurementDetailAndroid(Request $request)
    {
        
    }


    public function show($id)
    {
        $sparepartprocurement = SparepartProcurement::where('id',$id)->get()->first();
        $response = $this->generateItem($sparepartprocurement);
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
        try {
            date_default_timezone_set('Asia/Jakarta');
            $detail = $request->get('detail');
            
            $procurement=SparepartProcurement::findOrFail($id);
            $procurement->sparepart_procurement_details()->delete();
            $procurement->tanggal=$request->get('tanggal').' '.date('Y-m-d H:i:s');
            $procurement->status=$request->get('status');
            $procurement->id_sales=$request->get('id_sales');
            $procurement->save();
            $procurement = DB::transaction(function () use ($procurement,$detail) {
                $procurement->sparepart_procurement_details()->createMany($detail);
                return $procurement;
            });
            $response = $this->generateItem($procurement);
            return $this->sendResponse($response, 201);
        }catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('procurement_not_found');
        }
        catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function updateAndroid(Request $request, $id)
    {
        $procurement = SparepartProcurement::findOrFail($id);
        $procurement->status=1;
        $procurement->id_sales=$request->id_sales;
        $procurement->tanggal=$procurement->created_at;
        $procurement->save();
        return response()->json(['message'=>$procurement->id], 201); 
    }

    public function destroy($id)
    {
        try {
            $procurement=SparepartProcurement::findOrFail($id);
            $procurement->delete();
            return response()->json('Success',200);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('Procurement_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
