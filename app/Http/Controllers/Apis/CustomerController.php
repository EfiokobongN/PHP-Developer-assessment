<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use App\Utility\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    public function storeCustomer(StoreCustomerRequest $request){

        try {
            $cvPath =  $request->file('customer_cv')->store('cv', 'public');
    
            $auth = Util::Auth();
            $customer = new Customer();
            $customer->user_id = $auth->id;
            $customer->customer_name = $request->customer_name;
            $customer->customer_email = $request->customer_email;
            $customer->customer_phone = $request->customer_phone;
            $customer->customer_cv = $cvPath;
            $customer->save();

            return response()->json(['success'=>true, 'message' => 'Customer created successfully'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
        
    }


    public function apiEditCustomer(Request $request, $id){
        $editCustomer = Customer::find($id);
        try {
            if($request->hasFile('customer_cv')){
                Storage::delete('public/'.$editCustomer->customer_cv);  //delete old file before upload new one.
                $cvPath = $request->file('customer_cv')->store('cv', 'public');
            }else{
                $cvPath = $editCustomer->customer_cv;
            }
            $editCustomer->customer_name = $request->customer_name ?? $editCustomer->customer_name;
            $editCustomer->customer_email = $request->customer_email ?? $editCustomer->customer_email;
            $editCustomer->customer_phone = $request->customer_phone ?? $editCustomer->customer_phone;
            $editCustomer->customer_cv = $cvPath;
            $editCustomer->update();
            return response()->json(['success'=>true, 'message'=>'Customer Record Updated Successfully', 'editCustomer'=>$editCustomer]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
        
    }
}
