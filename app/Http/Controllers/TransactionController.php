<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\Sparepart;
use App\HistorySparepart;
use App\Transformers\TransactionTransformers;
use App\EmployeeOnDuty;


class TransactionController extends RestController
{
    private $subtotaltrans;
    protected $transformer = TransactionTransformers::class;
    

    public function index()
    {
        $transaction = Transaction::all();
        $response = $this->generateCollection($transaction);
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
        try {
            date_default_timezone_set('Asia/Jakarta');
            
            if($request->has('detailService'))
            {
                $service = $request->get('detailService');
            }
            if($request->has('detailSparepart'))
            {
                $sparepart = $request->get('detailSparepart');
            }
            if($request->has('employee'))
            {
                $employee = $request->get('employee');
            }
            
            $transaction = new Transaction();
            
            $count = Transaction::get()->count()+1;
            $strpad = str_pad($count , 3, 0, STR_PAD_LEFT);
            if($request->get('id_transaction_type')=='1') // service
            {
                $transaction->id='SV'.'-'.date("d").date("m").date("y").'-'.$strpad;
            }
            else if($request->get('id_transaction_type')=='2') // sparepart
            {
                $transaction->id='SP'.'-'.date("d").date("m").date("y").'-'.$strpad;
            }
            else if($request->get('id_transaction_type')=='3') // service and sparepart
            {
                $transaction->id='SS'.'-'.date("d").date("m").date("y").'-'.$strpad;
            }

            $transaction->tanggal=$request->get('tanggal').' '.date('H:i:s');
            $transaction->status=$request->status; // 0 = on proccess 1 = selesai
            $transaction->status_paid=0; //0 = unpaid 1=paid
            $transaction->id_transaction_type=$request->id_transaction_type;
            $transaction->discount=0;
            $transaction->subtotal=$request->subtotal;
            $transaction->id_customer=$request->id_customer;
            $transaction->save();
            
            if($request->has('employee'))
            {
                $transaction = DB::transaction(function () use ($transaction,$employee) {
                    $transaction->employees_onduty()->attach($employee);
                    return $transaction;
                });
            }

            if($request->has('detailService'))
            {
                $transaction = DB::transaction(function () use ($transaction,$service) {
                    $transaction->service_transaction()->createMany($service);
                    return $transaction;
                });
            }

            if($request->has('detailSparepart'))
            {
                $transaction = DB::transaction(function () use ($transaction,$sparepart) {
                    $transaction->sparepart_transaction()->createMany($sparepart);
                    return $transaction;
                });
            }

            $response = $this->generateItem($transaction);
            return $this->sendResponse($response, 201);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            date_default_timezone_set('Asia/Jakarta');
            $service = $request->detailService;
            $sparepart = $request->detailSparepart;
            $transaction = Transaction::find($id);
            // $t= Transaction::with('sparepart_transaction')->get();
            // foreach($t as $value)
            // {
            //     if($value->id==$id)
            //     {
            //         $sparepart2 = $value->sparepart_transaction;
            //     }
            // }
            // // $sparepart2 = $t->detail_spareparts;
            // foreach($sparepart2 as $value)
            // {
            //     $data = Sparepart::find($value->id_sparepart);
            //     $data->stok = $data->stok + $value->jumlah;
            //     $data->save();
            // }
            $transaction->service_transaction()->forceDelete();
            $transaction->sparepart_transaction()->forceDelete();
            $placement = explode('-',trim($transaction->id));
            if($request->get('id_transaction_type')!=$transaction->id_transaction_type)
            {
                $count = Transaction::get()->count()+1;
                
                if($request->get('id_transaction_type')=='1')
                {
                    $transaction->id='SV'.'-'.$placement[1].'-'.$placement[2];
                }
                else if($request->get('id_transaction_type')=='2')
                {
                    $transaction->id='SP'.'-'.$placement[1].'-'.$placement[2];
                }
                else if($request->get('id_transaction_type')=='3')
                {
                    $transaction->id='SS'.'-'.$placement[1].'-'.$placement[2];
                }
            }         
            $transaction->tanggal=$transaction->created_at;
            $transaction->status=$request->status;
            $transaction->status_paid=0; // 0 = belum bayar
            $transaction->id_transaction_type=$request->id_transaction_type;
            $transaction->discount=0;
            $transaction->subtotal=$request->subtotal;
            $transaction->id_customer=$request->id_customer;
            $transaction->save();
                       
            if($request->has('detailService'))
            {
                $transaction = DB::transaction(function () use ($transaction,$service) {
                    $transaction->service_transaction()->createMany($service);
                    return $transaction;
                });
            }

            if($request->has('detailSparepart'))
            {
                $transaction = DB::transaction(function () use ($transaction,$sparepart) {
                    $transaction->sparepart_transaction()->createMany($sparepart);
                    return $transaction;
                });
            }

            $response = $this->generateItem($transaction);
            return $this->sendResponse($response, 201);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function verification(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $subtotaltrans = $this->subtotaltrans;
        $transaction = Transaction::find($id);
        $transaction->status=1; // 0 = on process, 1 = selesai
        $transaction->discount = $request->discount;
        
        $t = Transaction::findOrFail($id)->with('sparepart_transaction','service_transaction')->where('id', $id)->get()->first();
        $tdetailsp = $t->sparepart_transaction;
        foreach($tdetailsp as $historysave)
        {
            $history = new HistorySparepart();
            $history->id_sparepart = $historysave->id_sparepart;
            $history->tanggal = $request->get('tanggal').' '.date('Y-m-d H:i:s');
            $history->jumlah = $historysave->jumlah;
            $history->satuan_harga = $historysave->harga_satuan;
            $history->subtotal = $historysave->subtotal;
            $history->status = 2; // 1 = pengadaan 2 = penjualan
            $subtotaltrans = $subtotaltrans + $historysave->subtotal;
            $history->save();
        }

        $tdetailsv = $t->service_transaction;
        foreach($tdetailsv as $svtrans)
        {
            $subtotaltrans = $subtotaltrans + $svtrans->subtotal;       
        }
        
        $transaction->subtotal = $subtotaltrans;
        $transaction->save();
        return response()->json(['status'=>'success','message' => 'Verifikasi sukses'], 201);
        
    }

    public function storeAndroid(Request $request)
    {
            date_default_timezone_set('Asia/Jakarta');
            
            $transaction = new Transaction();
            $count = Transaction::get()->count()+1;
            $strpad = str_pad($count , 3, 0, STR_PAD_LEFT);

            if($request->id_transaction_type == '1') // service
            {
                $transaction->id='SV'.'-'.date("d").date("m").date("y").'-'.$strpad;
            }
            else if($request->id_transaction_type == '2') // sparepart
            {
                $transaction->id='SP'.'-'.date("d").date("m").date("y").'-'.$strpad;
            }
            else if($request->id_transaction_type == '3') // service and sparepart
            {
                $transaction->id='SS'.'-'.date("d").date("m").date("y").'-'.$strpad;
            }
            $transaction->tanggal=$request->get('tanggal').' '.date('Y-m-d H:i:s');
            $transaction->status=$request->status; // 1 = on proccess | 2 = process | 3 = success
            $transaction->status_paid=0; //0 = unpaid 1=paid
            $transaction->id_transaction_type=$request->id_transaction_type;
            $transaction->discount=0;
            $transaction->subtotal=$request->subtotal;
            $transaction->id_customer=$request->id_customer;
            $transaction->save();

            $employeeonduty = new EmployeeOnDuty();
            $employeeonduty->id_employee = $request->id_employee;
            $employeeonduty->id_transaction = $transaction->id;
            $employeeonduty->save();


            return response()->json(['message'=>$transaction->id], 201); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::where('id',$id)->get()->first();
        $response = $this->generateItem($transaction);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     try {
    //         date_default_timezone_set('Asia/Jakarta');
    //         $service = $request->service;
    //         $sparepart = $request->sparepart;
    //         $transaction = Transaction::find($id);
    //         $t= Transaction::with('sparepart_transaction')->get();
    //         foreach($t as $value)
    //         {
    //             if($value->id==$id)
    //             {
    //                 $sparepart2 = $value->sparepart_transaction;
    //             }
    //         }
    //         // $sparepart2 = $t->detail_spareparts;
    //         foreach($sparepart2 as $value)
    //         {
    //             $data = Sparepart::find($value->id_sparepart);
    //             $data->stok = $data->stok + $value->jumlah;
    //             $data->save();
    //         }
    //         $transaction->service_transaction()->delete();
    //         $transaction->sparepart_transaction()->delete();
    //         if($request->get('transaction_type')!=$transaction->transaction_type)
    //         {
    //             $count = Transaction::get()->count();
                
    //             if($request->get('transaction_type')=='1')
    //             {
    //                 $transaction->id_transaction='SV'.'-'.date("d").date("m").date("y").'-'.$count;
    //             }
    //             else if($request->get('transaction_type')=='2')
    //             {
    //                 $transaction->id_transaction='SP'.'-'.date("d").date("m").date("y").'-'.$count;
    //             }
    //             else if($request->get('transaction_type')=='3')
    //             {
    //                 $transaction->id_transaction='SS'.'-'.date("d").date("m").date("y").'-'.$count;
    //             }
    //         }         
    //         $transaction->transaction_date=$transaction->created_at;
    //         $transaction->status=$request->status;
    //         $transaction->status_paid=0; // 0 = belum bayar
    //         $transaction->id_transaction_type=$request->id_transaction_type;
    //         $transaction->discount=0;
    //         $transaction->transaction_total=$request->subtotal;
    //         $transaction->id_customer=$request->id_customer;
    //         $transaction->save();
                       
    //         if($request->has('sparepart'))
    //         {
    //             $transaction = DB::transaction(function () use ($transaction,$service) {
    //                 $transaction->service_transaction()->createMany($service);
    //                 return $transaction;
    //             });
    //         }

    //         if($request->has('sparepart'))
    //         {
    //             $transaction = DB::transaction(function () use ($transaction,$sparepart) {
    //                 $transaction->sparepart_transaction()->createMany($sparepart);
    //                 return $transaction;
    //             });
    //         }
            
    //         if($request->has('sparepart'))
    //         {
    //             foreach($sparepart as $value)
    //             {
    //                 $data = Sparepart::find($value['id']);
    //                 $data->stok = $data->stok - $value['jumlah'];
    //                 $data->save();
                    
    //                 if($sparepart->stok<$sparepart->stok_minimal)
    //                 {
    //                     $token=['f_KfuL9RRSE:APA91bGiCux7tGrnKDJCIB9hAekL21HB4MZNlV8xr-0CHku7d3XGr2zAYbhhGgAwnRNEvntsRVTJ1A6yhg6MruNNwrVlk7VFnX5gOiZLfuf1QVBxE_y310yMv_W_AcuLcC2WRQC5yUEn'];
                        
    //                     $data = array('title' => $sparepart->nama ,'body' => 'Jumlah stok kurang dari stok minimal');
    //                             $fcmNotification = [
    //                                 'registration_ids' => $token, 
    //                                 // 'to'        => $token, //single token
    //                                 'priority' => "high",
    //                                 'notification' => $data,
    //                             ];
                            
                                
    //                             $url = 'https://fcm.googleapis.com/fcm/send';
    //                             $server_key = "AAAAbxBngYk:APA91bEfpbZBtyjWhDASp3wgD79iXKdZGVTS3qoSosfF7NGIY-2kzadipvWq-JwUkwVdiS6SZhGkPtA_VjsQqhnYBV0txs6l2x7Sx2KXq4mcAWocMBGMV2yTF_IzHhZRRp3ZrxeWbzAG";
    //                             $headers = [
    //                                 'Authorization: key='.$server_key,
    //                                 'Content-Type: application/json'
    //                             ];
    //                             $ch = curl_init();
    //                             curl_setopt($ch, CURLOPT_URL,$url);
    //                             curl_setopt($ch, CURLOPT_POST, true);
    //                             curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //                             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //                             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //                             curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    //                             $result = curl_exec($ch);
    //                             if ($result === FALSE) {
    //                                 return curl_error($ch);
    //                             }
    //                             curl_close($ch);
    //                 }
    //             }
    //         }
    //         $response = $this->generateItem($transaction);
    //         return $this->sendResponse($response, 201);
    //     } catch (\Exception $e) {
    //         return $this->sendIseResponse($e->getMessage());
    //     }
    // }


    public function updateAndroid(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        $transaction = Transaction::findorFail($id);
        
        $transaction->service_transaction()->forceDelete(); // hapus dulu semuanya nanti diisi lagi
        $transaction->sparepart_transaction()->forceDelete();

        $placement = explode('-',trim($transaction->id));

        if($request->id_transaction_type != $transaction->id_transaction_type)
        {
            
            if($request->get('id_transaction_type')=='1')
            {
                $transaction->id='SV'.'-'.$placement[1].'-'.$placement[2];
            }
            else if($request->get('id_transaction_type')=='2')
            {
                $transaction->id='SP'.'-'.$placement[1].'-'.$placement[2];
            }
            else if($request->get('id_transaction_type')=='3')
            {
                $transaction->id='SS'.'-'.$placement[1].'-'.$placement[2];
            }
        }         
        
        $transaction->transaction_date=$transaction->created_at;
        $transaction->status=0; //0 = on proccess 1 = sukses
        $transaction->transaction_paid=0; //0 = unpaid 1=paid
        $transaction->discount=0;
        $transaction->subtotal=0;
        $transaction->save();
    
        return response()->json(['message'=>$transaction->id], 201); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
