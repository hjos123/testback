<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function login(UserLoginRequest $request)
    {
      $user = User::where('email', $request->email)->first();
      if ( !empty($user->password) ) {
        if ( Hash::check($request->password, $user->password) )
        {
            $token = $user->createToken('FxunqUe5LHaB2vknEXqLdDNFbV5EiETpWRmbqqZ4')->accessToken;
            return response()->json(['token' => $token]);
        }
        else
          return response()->json(['error'=>'Contraseña incorrecta'], 202);
      }else
        return response()->json(['error'=>'Usuario Incorrecto'], 202);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Cierre de sesion exitoso.']);
    }

    public function register(UserRegisterRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        return response()->json(["message" => "Registro exitoso"]);
    }
}
