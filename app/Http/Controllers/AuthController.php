<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Employees;
use Illuminate\Support\Facades\Auth;
use App\Transformers\UserTransformers;

class AuthController extends RestController
{
    protected $transformer = UserTransformers::Class;
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api', ['except' => ['login','loginAndroid']]);
    }
  
    public function login(Request $request)
    {
      $credentials = $request->only(['username', 'password']);

      if (!$token = auth()->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
      }

      return $this->respondWithToken($token);
    }

    public function loginAndroid(Request $request)
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

    protected function respondWithToken($token)
    {
      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
        //'role' => auth()->user()->id_roles
      ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    
}
