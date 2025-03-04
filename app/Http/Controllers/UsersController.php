<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use App\Utility\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    //
    public function index(){
        $auth = Util::Auth();
        $data['userCustomers'] = Customer::where('user_id', $auth->id)->get();
        return view('users.index', $data);
    }


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

            return back();
        } catch (\Throwable $th) {
            return back()->with(['error' => $th->getMessage()], 500);
        }
        
    }

    public function editCustomer(Request $request){
        $editCustomer = Customer::find($request->id);
        if(!$editCustomer){
            return back()->with(['error' => 'Customer not found'], 404);
        }
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
        return back()->with('success', 'Customer Details Updated Successfully');
    }

    public function deleteCustomer(Request $request)
    {
        $deleteCustomer = Customer::find($request->id);
        if(!$deleteCustomer){
            return back()->with(['error' => 'Customer not found'], 404);
        }
        Storage::delete('public/'.$deleteCustomer->customer_cv);  //delete file before delete from database.
        $deleteCustomer->delete();
        return back()->with('success', 'Customer Deleted Successfully');
    }
}
