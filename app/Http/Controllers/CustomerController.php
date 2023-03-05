<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function import(){
        //will do if it is required in future
    }

    public function cachedResults(){
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $customer = Customer::search($request->get('query'))->paginate();
        return response()->json($customer);
    }
    public function index(): \Illuminate\Http\JsonResponse
    {
        $customer =  Customer::paginate();
        return response()->json($customer);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $customer =  Customer::find($id);
        return response()->json($customer);
    }
    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $customer =  Customer::find($id);
        if(!empty($customer)){
            try{
                $customer->delete();
            }catch (\Exception $e){
                Log::critical($e->getMessage());
            }
        }

        return response()->json(null,204);
    }

    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
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
        $customer->name = $request->input('name');
        $customer->email=$request->input('email');
        $customer->phone=$request->input('phone');
        $customer->address=$request->input('address');
        $customer->city=$request->input('city');
        $customer->state=$request->input('state');
        $customer->customer_type=$request->input('customer_type');
        $customer->birthdate=date($request->input('birthdate'));
        $customer->gender=$request->input('gender');
        $customer->status=$request->input('status');
        try {
            $customer->save();
        }catch (\Exception $e){
            Log::critical($e->getMessage());
        }
        return response()->json($customer,201);
    }

    public function update(Request $request,$id): \Illuminate\Http\JsonResponse
    {
        $customer = Customer::findOrFail($id);
        if(empty($customer)) {
            return response()->json(["error" => 'Record not found!'], 400);
        }
        $validator = Validator::make($request->all(), array(
            "name" => 'bail|required|max:40',
            'email' => 'bail|required|email:rfc,dns',
            "phone" => 'bail|required|numeric|digits:10',
            "address"=>'bail|required|max:255',
            "city"=>'bail|required|max:50',
            "state"=>'bail|required|max:50',
            "customer_type"=>'bail|numeric',
            "birthdate"=>'bail|date',
            "gender"=>"bail|bool",
            "status"=>'bail|required|bool'
        ));
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        try{
            $customer->fill($request->all())->save();
        }catch(\Exception $e){
            Log::critical($e->getMessage());
        }
        return response()->json($customer,200);
    }
}
