<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(){
        $customer =  Customer::all();
        return response()->json($customer);
    }

    public function show($id){
        $customer =  Customer::find($id);
        return response()->json($customer);
    }
    public function delete($id){
        $customer =  Customer::find($id);
        $customer->delete();
        return response()->json($customer);
    }

    public function create(Request $request){

        $validator = Validator::make($request->all(), array(
            "name" => 'bail|required|max:40',
            'email' => 'bail|required|unique:customers|email:rfc,dns',
            "phone" => 'bail|required|unique:customers|numeric|digits:10',
            "address"=>'bail|required|max:255',
            "city"=>'bail|required|max:50',
            "state"=>'bail|required|max:50',
            "customer_type"=>'bail|numeric',
            "birthdate"=>'bail|date',
            "gender"=>"bail|bool",
            "status"=>'bail|bool'
        ));

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $customer =  new Customer();
        $customer->name = $request->name;
        $customer->email=$request->email;
        $customer->phone=$request->phone;
        $customer->address=$request->address;
        $customer->city=$request->city;
        $customer->state=$request->state;
        $customer->customer_type=$request->customer_type;
        $customer->birthdate=date($request->birthdate);
        $customer->gender=$request->gender;
        $customer->status=$request->status;
        $customer->save();
        return response()->json($customer,201);
    }

    public function update(Request $request,$id){

        $customer =  Customer::find($id);
        $customer->name = $request->name;
        $customer->email=$request->email;
        $customer->phone=$request->phone;
        $customer->address=$request->address;
        $customer->city=$request->city;
        $customer->state=$request->state;
        $customer->customer_type=$request->customer_type;
        $customer->birthdate=date($request->birthdate);
        $customer->gender=$request->gender;
        $customer->status=$request->status;
        $customer->save();
        return response()->json($customer);
    }
}
