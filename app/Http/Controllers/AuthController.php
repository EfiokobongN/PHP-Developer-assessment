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

    public function __construct()
    {
        $this->middleware("identifier");
    }
    

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile_phone' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
            try {
                
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->mobile_phone = $request->mobile_phone;
                $user->password = Hash::make($request->password);
                $user->save();

                Auth::login($user);
                return redirect()->route('user.index')->with(['success' =>'User registered successfully']);
            } catch (\Throwable $th) {

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
                $message = "Login successful";
                return redirect()->route('user.index')->with(['success' =>$message]);
            
        } else {
            return back()->with(['error' => 'Invalid credentials']);
        }
    }
}
