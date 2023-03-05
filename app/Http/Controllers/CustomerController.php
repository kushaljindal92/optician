<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @TODO error logging
 * @TODO do unit testing
 */
class CustomerController extends Controller
{

    public function search(Request $request){
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
            $customer->delete();
            $response = array('Customer has been deleted successfully');
        }else{
            $response = array(
                'Customer do not find'
            );
        }

        return response()->json($response,200);
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
        $customer->fill($request->all())->save();

        return response()->json($customer,200);
    }
}
