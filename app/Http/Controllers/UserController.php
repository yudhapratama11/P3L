<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Transformers\UserTransformers;
use App\Employees;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;


class UserController extends RestController
{
    protected $transformer = UserTransformers::Class;

    public function index()
    {
        $users = User::all();
        return $users;
    }
    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validateWith([
            'nama' => 'required|max:255',
            'username' => 'max:10|unique:users',
            'nomor_telepon' => 'max:255',
            'password' => 'max:15',
            'alamat' => 'max:255',
            'gaji' => 'max:12',
            'id_branch' => 'required|max:1',
            'id_roles' => 'required|max:1'
          ]);
  
          if($request->id_role != "3")
          {
            $password = trim($request->password);
            
            $user = new User();
            $user->username = $request->username;
            $user->password = Hash::make($password);
            $user->save();
          }

          $employees = new Employees();
          $employees->nama = $request->nama;
          $employees->nomor_telepon = $request->nomor_telepon;
          $employees->alamat = $request->alamat;
          $employees->gaji = $request->gaji;
          $employees->id_branch = $request->id_branch;
          $employees->id_roles = $request->id_roles;
         
          if($request->id_roles != "3")
          {
             $employees->id_user = $user->id;
          }
          $employees->save();
    
          return response()->json(['status' => 'success','msg'=>'User berhasil dibuat']);
    }

    public function getAuthenticatedUser()
    {
        try{
            try {
    
                if (! $user = JWTAuth::parseToken()->authenticate()) {
                            return response()->json(['user_not_found'], 404);
                    }

            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                return response()->json(['token_expired'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                    return response()->json(['token_invalid'], $e->getStatusCode());

            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                    return response()->json(['token_absent'], $e->getStatusCode());

            }
            $userdata = User::with(['employees','employees.role','employees.branch'])->where('id',$user->id)->first();
            //return $userdata;
            $response = $this->generateItem($userdata);
            
            return $this->sendResponse($response, 201);
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }


    public function updatePassword(Request $request) // web platform
    {
        $this->validateWith([
            'password_lama' => 'required',
            'password_baru' => 'required',
        ]);

        $user = User::findOrFail(JWTAuth::parseToken()->authenticate()->id);
        if(Hash::check($request->password_lama, $user->password))
        {
            $user->password = Hash::make($request->password_baru);    
            $json=['status' => 'success','msg'=>'Password berhasil diubah'];
        }
        else
        {
            $json=['status' => 'failed','msg'=>'Password yang anda masukkan salah, silahkan coba lagi'];
        }
          $user->save();
          
          return response()->json($json);
    }

    public function updatePasswordAndroid(Request $request, $id)
    {
        $this->validateWith([
            'password_lama' => 'required',
            'password_baru' => 'required',
        ]);

        $user = User::findOrFail($id);
        if(Hash::check($request->password_lama, $user->password))
        {
            $user->password = Hash::make($request->password_baru);    
            $json=['status' => 'success','msg'=>'Password berhasil diubah'];
            $user->save();
        }
        else
        {
            $json=['status' => 'failed','msg'=>'Password yang anda masukkan salah, silahkan coba lagi'];
        }
        
          
        return response()->json($json);
    }
}
