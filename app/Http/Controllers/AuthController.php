<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utility\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'Mobile_Phone' => 'required|string|Mobile_Phone|max:12|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
            DB::beginTransaction();
            try {
                
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->Mobile_Phone = $request->Mobile_Phone;
                $user->password = Hash::make($request->password);
                $user->save();
                DB::commit();
                Auth::login($user);
                return back()->with(['success' => true, 'message' => 'User registered successfully']);
            } catch (\Throwable $th) {
                DB::rollBack();
                return back()->with(['error' => 'Something went wrong, please try again later']);
            }
        
    }

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
            return back()->with(['success' => true, 'message' => $message], 200);
        } else {
            return back()->with(['error' => false, 'message' => 'Invalid credentials']);
        }
    }
}
