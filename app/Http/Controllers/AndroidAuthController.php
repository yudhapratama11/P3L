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
          $response = $this->generateItem($userdata);
          return $this->sendResponse($response, 201);
      } 
      else{ 
          return response()->json('gagal', 401); 
      } 
    }
}
