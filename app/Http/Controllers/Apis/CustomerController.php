<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Utility\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{

    public function apiStoreCustomer(Request $request){

        $validator = Validator::make($request->all(), [
            'customer_name' =>'required|string|max:255',
            'customer_email' =>'required|max:255|unique:customers',
            'customer_phone' =>'required|max:12|unique:customers',
            'customer_cv' =>'file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {

        $cvPath= null; 

        if ($request->hasFile('customer_cv')) {
            $file = $request->file('customer_cv');
            $extension = strtolower($file->getClientOriginalExtension());
            $fileName = uniqid() . '.' . $extension;
            $cvPath = env("BASE_URL") . "storage/cv/" . $fileName; 
        }

            $auth = Util::Auth();
            $customer = new Customer();
            $customer->user_id = $auth->id;
            $customer->customer_name = $request->customer_name;
            $customer->customer_email = $request->customer_email;
            $customer->customer_phone = $request->customer_phone;
            $customer->customer_cv = $cvPath;
            $customer->save();

            return response()->json(['success'=>true, 'message' => 'Customer created successfully', 'customer'=>$customer], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
        
    }


    public function apiEditCustomer(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'customer_name' =>'string|max:255',
            'customer_email' =>'max:255|string',
            'customer_phone' =>'max:12|string',
            'customer_cv' =>'file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $apiEditCustomer = Customer::find($id);
        if(!$apiEditCustomer){
            return response()->json(['message'=>'Customer not found'], 404);
        }
        try {

        if ($request->hasFile('customer_cv')) {
            $file = $request->file('customer_cv');
            $extension = strtolower($file->getClientOriginalExtension());
            $fileName = uniqid() . '.' . $extension;
            $cvPath = env("BASE_URL") . "storage/cv/" . $fileName; 
        }
            $apiEditCustomer->customer_name = $request->customer_name ?? $apiEditCustomer->customer_name;
            $apiEditCustomer->customer_email = $request->customer_email ?? $apiEditCustomer->customer_email;
            $apiEditCustomer->customer_phone = $request->customer_phone ?? $apiEditCustomer->customer_phone;
            $apiEditCustomer->customer_cv = $cvPath ?? $apiEditCustomer->customer_cv;
            $apiEditCustomer->save();
            return response()->json(['success'=>true, 'message'=>'Customer Record Updated Successfully', 'editCustomer'=>$apiEditCustomer]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
        
    }

    public function getCustomer($id)
    {
        $customer = Customer::find($id);
        if(!$customer){
            return response()->json(['message'=>'Customer not found'], 404);
        }
        return response()->json(['success'=>true, 'customer'=>$customer]);
    }
}
