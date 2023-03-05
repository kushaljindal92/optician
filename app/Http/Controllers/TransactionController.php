<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function import(){
        //will do if it is required in future
    }

    public function cachedResults(){
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $transaction = Transaction::search($request->get('query'))->paginate();
        return response()->json($transaction);
    }
    public function index(): \Illuminate\Http\JsonResponse
    {
        $transaction =  Transaction::paginate();
        return response()->json($transaction);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $Transaction =  Transaction::find($id);
        return response()->json($Transaction);
    }
    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $Transaction =  Transaction::find($id);
        if(!empty($Transaction)){
            try{
                $Transaction->delete();
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
            'amount' => 'bail|required|decimal',
            "refund" => 'bail|required|decimal',
            "balance"=>'bail|required|decimal',
            "comment"=>'bail|required|comment',
        ));

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        $customer = Customer::findOrFail($customer_id);
        $transaction =  new Transaction();
        $transaction->customer()->associate($customer);
        $transaction->amount = $request->input('type');
        $transaction->refund = $request->input('power');
        $transaction->balance = $request->input('spherical');
        $transaction->comment = $request->input('cylindrical');

        try {
            $transaction->save();
        }catch (\Exception $e){
            Log::critical($e->getMessage());
        }
        return response()->json($transaction,201);
    }

    public function update(Request $request,$id): \Illuminate\Http\JsonResponse
    {
        $transaction = Transaction::findOrFail($id);
        if(empty($transaction)) {
            return response()->json(["error" => 'Record not found!'], 400);
        }
        $validator = Validator::make($request->all(), array(
            "customer_id" => 'bail|required|numeric',
            'amount' => 'bail|required|decimal',
            "refund" => 'bail|required|decimal',
            "balance"=>'bail|required|decimal',
            "comment"=>'bail|required|comment',
        ));
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        try{
            $transaction->fill($request->all())->save();
        }catch(\Exception $e){
            Log::critical($e->getMessage());
        }
        return response()->json($transaction,200);
    }
}
