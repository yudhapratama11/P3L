<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Employees;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
//use App\Transformers\UserTransformer;

class UserController extends RestController
{
    protected $transformer = UserTransfomer::Class;

    public function index()
    {
        $users = Employees::all();
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
            'username' => 'max:255|unique:users',
            'nomor_telepon' => 'max:255',
            'password' => 'max:255',
            'alamat' => 'max:255',
            'gaji' => 'max:255',
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
            //$userdata = User::where('id',$user->id)->first();
            $userdata=User::find($user->id);
            $response = $this->generateItem($userdata,UserTransfomer::Class);
            
            return $this->sendResponse($response, 201);
            //$userdata = Employees::join('users','users.id','=','employees.id_user')->where('users.id',$user->id)->first();
            //$userdata = User::with(['detail'])->where('id',$user->id)->first();
            //return response()->json(compact('userdata'));
    }

    // public function UniqueEmail($username)
    // {
    //     return json_encode(User::where('username', '=', $username)->exists());
    // }
}
