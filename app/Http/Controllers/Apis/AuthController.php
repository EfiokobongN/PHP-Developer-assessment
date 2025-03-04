<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Utility\Util;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' =>'required|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($validate)){
            $user = Util::Auth();
            if(!$user->email)
            {
                $message = "No account associated with this email address";
            }else{
                $message = "Login successful";
            }

            $tokenResult = $user->createToken('token_name');
            $token = $tokenResult->plainTextToken;
            $expiration = Carbon::now()->addHour(3);
            $tokenResult->accessToken->expires_at = $expiration;
            $tokenResult->accessToken->save();
            $response = response()->json(['success'=> true, 'message' => $message, 'user' => $user,'access_token' => $token,'expires_at' => $expiration
            ], 200);
        }else{
            $response = response()->json(['success' => false,'message' => 'Invalid Login credentials'], 401);
        }

        return $response;

    }
}
