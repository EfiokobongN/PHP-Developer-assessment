<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Utility\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    //
    public function index(){
        $auth = Util::Auth();
        $data['userCustomers'] = Customer::where('user_id', $auth->id)->get();
        return view('users.index', $data);
    }


    public function storeCustomer(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'customer_name' =>'required|string|max:255',
                'customer_email' =>'required|max:255|unique:customers',
                'customer_phone' =>'required|max:12|unique:customers',
                'customer_cv' =>'required',
            ]);
    
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $cvPath =  $request->file('customer_cv')->store('cv', 'public');
    
            $auth = Util::Auth();
            $customer = new Customer();
            $customer->user_id = $auth->id;
            $customer->customer_name = $request->customer_name;
            $customer->customer_email = $request->customer_email;
            $customer->customer_phone = $request->customer_phone;
            $customer->customer_cv = $cvPath;
            $customer->save();

            return back();
        } catch (\Throwable $th) {
            return back()->with(['error' => $th->getMessage()], 500);
        }
        
    }

    public function editCustomer(){

    }
}
