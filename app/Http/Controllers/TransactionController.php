<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Sparepart;
use App\Transformers\TransactionTransformers;


class TransactionController extends Controller
{
    protected $transformer = TransactionTransformer::class;

    public function index()
    {
        $transactions = Transaction::all();
        $response = $this->generateCollection($transactions);
        return $this->sendResponse($response);
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
            
            $service = $request->service;
            $sparepart = $request->sparepart;
            $employee = $request->employee;
            
            $transaction = new Transaction;
            
            $count = Transaction::get()->count()+1;
            if($request->get('transaction_type')=='1') // service
            {
                $transaction->id_transaction_type='SV'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            else if($request->get('transaction_type')=='2') // sparepart
            {
                $transaction->id_transaction_type='SP'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            else if($request->get('transaction_type')=='3') // service and sparepart
            {
                $transaction->id_transaction_type='SS'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            $transaction->transaction_date=$request->get('tanggal').' '.date('Y-m-d H:i:s');
            $transaction->status=$request->status;
            $transaction->transaction_paid=0; //0 = unpaid 1=paid
            $transaction->transaction_type=$request->transaction_type;
            $transaction->discount=0;
            $transaction->subtotal=$request->subtotal;
            $transaction->id_customer=$request->id_customer;
            $transaction->save();
            
            $transaction = DB::transaction(function () use ($transaction,$employee) {
                $transaction->employees()->attach($employee);
                return $transaction;
            });
            $transaction = DB::transaction(function () use ($transaction,$service) {
                $transaction->detail_services()->createMany($service);
                return $transaction;
            });
            $transaction = DB::transaction(function () use ($transaction,$sparepart) {
                $transaction->detail_spareparts()->createMany($sparepart);
                return $transaction;
            });
            foreach($sparepart as $value)
            {
                $data = Sparepart::find($value['id_sparepart']);
                $data->stock = $data->stock - $value['detail_sparepart_amount'];
                $data->save();
                if($data->stock<$data->min_stock)
                {
                    $token=['cBy9I4NDXro:APA91bF0sDMutZo5aQo4VY9hMfmoOvY3mUjSXWwdZaGsKNVRgOtWRgVyBGX-SIAWRdbFLnURZQ-boB9_p3MaN03DUxKyyN-helrFnDgig_UdH2ffIGWCNSTsvdQ_FAbu42B-iPbzkvaK','fzQS5wVJYt4:APA91bG8Ldrp_8ksxZyC446z1TkPkux5_a8bpRkAwIDhEh7exYw6n4WoYUesq9EAKoUWG6FS5xHp1DxoVBU2andL1elkCqB4IpmTLIAYGVkOUEAMAGOR1XJ9DH6HoR6-A72K3O0rFLrd','cpb9nmgdPwg:APA91bFB2HkGGRhaPmzhkrAq7g2TjFsrYvTJ_S6DrjVhLGWaG7sy2S8nqIMi5JfAkX96Er-WvXdMbhrycSbRY4L49P_BUDW32nrzDJinUMW-UgfZqTEi8OfeQOnUBqv869Hdf_Yw-ybd','evv7Xzo4w_Y:APA91bEz8LNHRLzG4hqOY5ExDoF_50uy9dQdnCpt3bCGf-LezeUgGtzLXzLCx2wrTSfuRV6hSKr7tDEz8pYg0uZwHSG6JLWPrkzkKBWbSxsLAkT6Kp4R-1fRsRAyXkgYg6q81LwhPgxa'];
                    // $notification = [
                    //     'body' => 'this is test',
                    //     'sound' => true,
                    // ];
                    
                    $data = array('title' => $data->sparepart_name ,'body' => 'kurang dari jumlah stock minimal');
                    $fcmNotification = [
                        'registration_ids' => $token, 
                        // 'to'        => $token, //single token
                        'priority' => "high",
                        'notification' => $data,
                    ];
                
                    
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $server_key = "AAAA49vwxPw:APA91bGsqHe9cRCcMcU2X47Tao1GWIDbA029PnPxgXaSL5wEvia2mJJiuINEV0dt-Wy9e2Jls8OV3T87h6SsH70DmitZg8J0f3aeENRCuoLDIWH58o9lXNKNc_4wSZ35Ya8cXwiNq0jX";
                    $headers = [
                        'Authorization: key='.$server_key,
                        'Content-Type: application/json'
                    ];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    if ($result === FALSE) {
                        return curl_error($ch);
                    }
                    curl_close($ch);
                }
            }
            // return $result;
            $response = $this->generateItem($transaction);
            return $this->sendResponse($response, 201);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }


    public function storeAndroid(Request $request)
    {
        try {
            date_default_timezone_set('Asia/Jakarta');
            
            $service = $request->service;
            $sparepart = $request->sparepart;
            $employee = $request->employee;
            
            $transaction = new Transaction();
            
            $count = Transaction::get()->count()+1;
            if($request->get('transaction_type')=='1') // service
            {
                $transaction->id_transaction_type='SV'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            else if($request->get('transaction_type')=='2') // sparepart
            {
                $transaction->id_transaction_type='SP'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            else if($request->get('transaction_type')=='Service And 3') // service and sparepart
            {
                $transaction->id_transaction_type='SS'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            $transaction->transaction_date=$request->get('tanggal').' '.date('Y-m-d H:i:s');
            $transaction->status=$request->status;
            $transaction->transaction_paid=0; //0 = unpaid 1=paid
            $transaction->transaction_type=$request->transaction_type;
            $transaction->discount=0;
            $transaction->subtotal=$request->subtotal;
            $transaction->id_customer=$request->id_customer;
            $transaction->save();
        
            // return $result;
            $response = $this->generateItem($transaction);
            return $this->sendResponse($response, 201);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function storeTransactionSparepartAndroid(Request $request)
    {
            date_default_timezone_set('Asia/Jakarta');
            
            $service = $request->service;
            $sparepart = $request->sparepart;
            $employee = $request->employee;
            
            $transaction = new Transaction();
            
            $count = Transaction::get()->count()+1;
            if($request->get('transaction_type')=='1') // service
            {
                $transaction->id_transaction_type='SV'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            else if($request->get('transaction_type')=='2') // sparepart
            {
                $transaction->id_transaction_type='SP'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            else if($request->get('transaction_type')=='Service And 3') // service and sparepart
            {
                $transaction->id_transaction_type='SS'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            $transaction->transaction_date=$request->get('tanggal').' '.date('Y-m-d H:i:s');
            $transaction->status=$request->status;
            $transaction->transaction_paid=0; //0 = unpaid 1=paid
            $transaction->transaction_type=$request->transaction_type;
            $transaction->discount=0;
            $transaction->subtotal=$request->subtotal;
            $transaction->id_customer=$request->id_customer;
            $transaction->save();
        
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
        //
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
    public function update(Request $request, $id)
    {
        //
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
