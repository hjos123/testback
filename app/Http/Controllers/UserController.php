<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{

    public function login(Request $request)
    {
         $validator = Validator::make($request->all(), [ 
        'email' => 'required|email', 
        'password' => 'required' 
        ]);

          if ($validator->fails()) 
            return response()->json(['error'=>$validator->errors()], 202);

		$user = User::where('email', $request->email)->first();
        if ( Hash::check($request->password, $user->password) )
        {
            $token = $user->createToken('nkve6RBesQ1oNmCFh9zAxNYvOi8rEAgWX1eSzzVk')->accessToken; 
            return response()->json(['token' => $token], 200); 
        }
        else
        {
            return response()->json(['error'=>'Unauthorised'], 401); 
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();        
        return response()->json(['message' => 'Cierre de sesion exitoso.'], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
        'name' => 'required', 
        'email' => 'required|email|unique:users', 
        'password' => 'required' 
        ]);

        if ($validator->fails()) 
            return response()->json(['error'=>$validator->errors()], 202);

        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input);
        return response()->json(["message" => "Registro exitoso"], 200);
    }
}
