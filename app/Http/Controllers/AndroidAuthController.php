<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformers;
use App\User;
use App\Employees;

class AndroidAuthController extends RestController
{
    protected $transformer = UserTransformers::Class;

    public function login(Request $request)
    {
      $credentials = $request->only(['username', 'password']);

      if(Auth::attempt($credentials))
      { 
          $userdata = User::with(['employees','employees.role','employees.branch'])->find(Auth::id());
          //return response()->json(['error'=>false,'message'=>'login success','data'=>$userdata],200);
           $response = $this->generateItem($userdata);
           return $this->sendResponseAndroid($response, 200);

      } 
      else{ 
        return response()->json(['error'=>true,'message'=>'login failed'], 400); 
      } 
    }
}
