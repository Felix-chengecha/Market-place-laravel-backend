<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Catch_;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function login(Request $request) {
        $creds = $request->only(['email', 'password']);
        if (!$token = auth()->attempt($creds)) {

            return response()->json([
                'success' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => Auth::User(),
        ]);
    }

    public function register(Request $request){
        $encryptpass=Hash::make($request->password);
        $user=new User;

        try{

            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=$encryptpass;

            $user->save();
            return $this->login($request);
        }
        Catch(Exception $e){
            return response()->json([
                        'success'=>false,
                        'message'=>$e->getMessage(),
            ]);

        }
    }

    public function logout(Request $request){
        try{

            JWTAuth::Invalidate(JWTAuth::parseToken($request->token));
               return response()->json([
                    'success' => true,
                    'message' =>"Logout Success"
               ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' =>$e->getMessage()
            ]);

        }

    }
}
