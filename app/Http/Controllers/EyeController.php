<?php

namespace App\Http\Controllers;

use App\Models\Eye;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class EyeController extends Controller
{
    public function import(){
        //will do if it is required in future
    }

    public function cachedResults(){
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $eye = Eye::search($request->get('query'))->paginate();
        return response()->json($eye);
    }
    public function index(): \Illuminate\Http\JsonResponse
    {
        $eye =  Eye::paginate();
        return response()->json($eye);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $eye =  Eye::find($id);
        return response()->json($eye);
    }
    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $eye =  Eye::find($id);
        if(!empty($eye)){
            try{
                $eye->delete();
            }catch (\Exception $e){
                Log::critical($e->getMessage());
            }
        }

        return response()->json(null,204);
    }

    public function create(Request $request,$customer_id): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), array(
            "customer_id" => 'bail|required|numeric',
            'type' => 'bail|required|numeric',
            "power" => 'bail|required|numeric',
            "spherical"=>'bail|required|numeric',
            "cylindrical"=>'bail|required|numeric',
            "axis"=>'bail|required|numeric'
        ));

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        $customer = Customer::findOrFail($customer_id);
        $eye =  new Eye();
        $eye->customer()->associate($customer);
        $eye->type = $request->input('type');
        $eye->power = $request->input('power');
        $eye->spherical = $request->input('spherical');
        $eye->clyndrical = $request->input('cylindrical');
        $eye->axis = $request->input('axis');

        try {
            $eye->save();
        }catch (\Exception $e){
            Log::critical($e->getMessage());
        }
        return response()->json($eye,201);
    }

    public function update(Request $request,$id): \Illuminate\Http\JsonResponse
    {
        $eye = Eye::findOrFail($id);
        if(empty($eye)) {
            return response()->json(["error" => 'Record not found!'], 400);
        }
        $validator = Validator::make($request->all(), array(
            "customer_id" => 'bail|required|numeric',
            'type' => 'bail|required|numeric',
            "power" => 'bail|required|numeric',
            "spherical"=>'bail|required|numeric',
            "cylindrical"=>'bail|required|numeric',
            "axis"=>'bail|required|numeric'
        ));
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        try{
            $eye->fill($request->all())->save();
        }catch(\Exception $e){
            Log::critical($e->getMessage());
        }
        return response()->json($eye,200);
    }
}
