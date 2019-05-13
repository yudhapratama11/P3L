<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sparepart;
use App\SparepartProcurement;
use App\HistorySparepart;
use \File;
use App\Transformers\SparepartTransformers;

class SparepartController extends RestController
{
    protected $transformer = SparepartTransformers::Class;
    
    public function __construct()
    {
        parent::__construct();
        $this->photos_path = public_path('/itemImages');
    }
    
    public function index()
    {
        $sparepart = Sparepart::orderBy('nama','asc')->get();
        $response = $this->generateCollection($sparepart);
        return $this->sendResponse($response, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'nama' => 'required',
            'merk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'stok_minimal' => 'required',
            'id_sparepart_type' => 'required',
            'penempatan' => 'required',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $sparepart = new Sparepart();
        $sparepart->id = $request->id;
        $sparepart->nama = $request->nama;
        $sparepart->merk = $request->merk;
        $sparepart->harga_beli = $request->harga_beli;
        $sparepart->harga_jual = $request->harga_jual;
        $sparepart->stok = $request->stok;
        $sparepart->stok_minimal = $request->stok_minimal;
        $sparepart->id_sparepart_type = $request->id_sparepart_type;
        $sparepart->penempatan = $request->penempatan;
        
        if($request->hasfile('gambar'))
        {
            $image = $request->file('gambar');
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $image->getClientOriginalExtension();
            $image->move($this->photos_path, $save_name);  
            $sparepart->gambar=$save_name;
        }

        $sparepart->save();
        
    //return $sparepart;
        $response = $this->generateItem($sparepart);
        return $this->sendResponse($response, 201);
    }

    public function sortStockTerdikit()
    {
        $sparepart = Sparepart::orderBy('stok','asc')->get();
        $response = $this->generateCollection($sparepart);
        return $this->sendResponse($response, 200);
    }

    public function sortStockTerbanyak()
    {
        $sparepart = Sparepart::orderBy('stok','desc')->get();
        $response = $this->generateCollection($sparepart);
        return $this->sendResponse($response, 200);
    }

    public function show($id)
    {
        $sparepart = Sparepart::where('id',$id)->get();
        $response = $this->generateCollection($sparepart);
        return $this->sendResponse($response, 200);
    }

    public function edit($id)
    {
        //
    }

    public function updateSparepart(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'merk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'stok_minimal' => 'required',
            'penempatan' => 'required',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->nama = $request->nama;
        $sparepart->merk = $request->merk;
        $sparepart->harga_beli = $request->harga_beli;
        $sparepart->harga_jual = $request->harga_jual;
        $sparepart->stok = $request->stok;
        $sparepart->stok_minimal = $request->stok_minimal;
        $sparepart->penempatan = $request->penempatan;

        if($request->hasfile('gambar'))
        {
            $gambarlama = $this->photos_path . '/' . $sparepart->gambar;
            if (file_exists($gambarlama)) {
                unlink($gambarlama);
            }
            $image = $request->file('gambar');
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $image->getClientOriginalExtension();
            $image->move($this->photos_path, $save_name);  
            $sparepart->gambar=$save_name;

        }
        if($sparepart->stok<$sparepart->stok_minimal)
        {
            $token=['eIoczThh-pI:APA91bGRMcQCktS0npeEWJc08pT-H8p5-tWDN6M4JmhtacJcU8iRzcQFxFEiwm5ubsgwBrvU5r3vSZLLGyaeQT0nzq43RpZ0-gfjtGF1e1WPe9Dn_909ObcciIiTeKpgOqt1AD3ypCWU'];
            
            $data = array('title' => $data->nama ,'body' => 'Jumlah stok kurang dari stok minimal');
                    $fcmNotification = [
                        'registration_ids' => $token, 
                        // 'to'        => $token, //single token
                        'priority' => "high",
                        'notification' => $data,
                    ];
                
                    
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $server_key = "AAAAbxBngYk:APA91bEfpbZBtyjWhDASp3wgD79iXKdZGVTS3qoSosfF7NGIY-2kzadipvWq-JwUkwVdiS6SZhGkPtA_VjsQqhnYBV0txs6l2x7Sx2KXq4mcAWocMBGMV2yTF_IzHhZRRp3ZrxeWbzAG";
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
        $sparepart->save();
        return response()->json(['status'=>'success','message' => 'Update sparepart sukses'], 200);
    }
    
    public function updateSparepartAndroid(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required',
            'merk' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'stok' => 'required',
            'stok_minimal' => 'required',
            'penempatan' => 'required',
        ]);
        
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->nama = $request->nama;
        $sparepart->merk = $request->merk;
        $sparepart->harga_beli = $request->harga_beli;
        $sparepart->harga_jual = $request->harga_jual;
        $sparepart->stok = $request->stok;
        $sparepart->stok_minimal = $request->stok_minimal;
        $sparepart->penempatan = $request->penempatan;

        $sparepart->save();
        if($sparepart->stok<$sparepart->stok_minimal)
        {
            $token=['f_KfuL9RRSE:APA91bGiCux7tGrnKDJCIB9hAekL21HB4MZNlV8xr-0CHku7d3XGr2zAYbhhGgAwnRNEvntsRVTJ1A6yhg6MruNNwrVlk7VFnX5gOiZLfuf1QVBxE_y310yMv_W_AcuLcC2WRQC5yUEn'];
            
            $data = array('title' => $sparepart->nama ,'body' => 'Jumlah stok kurang dari stok minimal');
                    $fcmNotification = [
                        'registration_ids' => $token, 
                        // 'to'        => $token, //single token
                        'priority' => "high",
                        'notification' => $data,
                    ];
                
                    
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $server_key = "AAAAbxBngYk:APA91bEfpbZBtyjWhDASp3wgD79iXKdZGVTS3qoSosfF7NGIY-2kzadipvWq-JwUkwVdiS6SZhGkPtA_VjsQqhnYBV0txs6l2x7Sx2KXq4mcAWocMBGMV2yTF_IzHhZRRp3ZrxeWbzAG";
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
        return response()->json(['status'=>'success','message' => 'Update sparepart sukses'], 201);
    }

    public function updateSparepartAndroidPicture(Request $request)
    {
        $this->validate($request, [
            'gambar.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $sparepart = Sparepart::findOrFail($request->id);

        if($request->hasfile('gambar'))
        {
            $gambarlama = $this->photos_path . '/' . $sparepart->gambar;
            if (file_exists($gambarlama)) {
                unlink($gambarlama);
            }
            $image = $request->file('gambar');
            $name = sha1(date('YmdHis') . str_random(30));
            $save_name = $name . '.' . $image->getClientOriginalExtension();
            $image->move($this->photos_path, $save_name);  
            $sparepart->gambar=$save_name;

        }
        $sparepart->save();
        return response()->json(['status'=>'success','message' => 'Update sparepart sukses'], 201);
    }

    public function destroy($id) //SoftDelete
    {
        $employees = Sparepart::findOrFail($id);
        $employees->delete();

    	return response()->json(['status' => 'success','message'=>'Berhasil menghapus'],202);
    }

    public function checkSparepartStock()
    {
        $sparepart = Sparepart::whereRaw('stok_minimal > stok')->get();
        $response = $this->generateCollection($sparepart);
        return $this->sendResponse($response, 201);

    }
    
    public function sparepartVerification(Request $request, $id)
    {
        try {
            date_default_timezone_set('Asia/Jakarta');
            $sparepartproc = SparepartProcurement::findOrFail($id);
            $sparepartproc->status = 1;
            $spareparts = $request->get('spareparts');
            foreach($spareparts as $sparepart)
            {
                $data=Sparepart::findorFail($sparepart['id']);
                $data->stok = $data->stok + $sparepart['stok'];
                $data->harga_beli = $sparepart['harga_beli'];
                $data->save();

                $history = new SparepartHistory();
                $history->id_sparepart = $sparepart['id'];
                $history->tanggal=$request->get('tanggal').' '.date('Y-m-d H:i:s');
                $history->jumlah=$sparepart['stok'];
                $history->satuan_harga = $sparepart['harga_beli'];
                $history->subtotal = $sparepart['stok'] * $sparepart['harga_beli'];
                $history->status = 1;
                $history->save();
            }
            return response()->json('Success',201);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('sparepart_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function sortPriceTermahal()
    {
        $sparepart = Sparepart::orderBy('harga_jual','desc')->get();
        $response = $this->generateCollection($sparepart);
        return $this->sendResponse($response, 200);
    }

    public function sortPriceTermurah()
    {
        $sparepart = Sparepart::orderBy('harga_jual','asc')->get();
        $response = $this->generateCollection($sparepart);
        return $this->sendResponse($response, 200);
    }
}
