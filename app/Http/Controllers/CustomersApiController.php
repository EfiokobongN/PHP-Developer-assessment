<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Utility\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomersApiController extends Controller
{
    public function storeCustomer(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'customer_name' =>'required|customer_name|string|max:255',
                'customer_email' =>'required|customer_email|max:255|unique:customers',
                'customer_phone' =>'required|customer_phone|max:12|unique:customers',
                'customer_cv' =>'required|customer_cv',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
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

            return response()->json(['message' => 'Customer created successfully'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
        
    }
}
