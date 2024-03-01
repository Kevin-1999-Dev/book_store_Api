<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
     /**
     * Read customers
     * Get - api/customers
     */
    public function index(){
        try{
       $customers = Customer::all();
            return response()->json([
                'customers'=> $customers,
                'status'=>200
            ],200);
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ],500);
        }
    }
    /**
     * Create a customer
     * Post - api/customer
     * @param mixed name,address,city
     */
    public function store(Request $request){
        try{
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'city' => 'required',
            ]);

            if($validation->fails()){
                return response()->json([
                    'ErrorMessage'=> $validation->errors(),
                    'status'=>400
                ],400);
            }

           $customer = Customer::create([
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
            ]);
            return response()->json([
                'data' => $customer,
                'message'=> 'Created Success...',
                'status' => 201,
            ],201);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ],500);
        }
    }
      /**
     * Update a customer
     * Post - api/customer/{id}
     * @param mixed name,address,city,id(customer)
     */
    public function update($id,Request $request){
        try{
            $customer  = Customer::find($id);
            if(!$customer){
                return response()->json([
                    [
                        'message' => "Customer Not Found!!!",
                        'status' => 404,
                    ]
                ], 404);
            }
            $validation = Validator::make($request->all(), [
                'name' => 'required',
                'address' => 'required',
                'city' => 'required',
            ]);

            if($validation->fails()){
                return response()->json([
                    'ErrorMessage'=> $validation->errors(),
                    'status'=>400
                ],400);
            }
            $customer->update([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city
            ]);

            return response()->json([
                'data' => $customer,
                'message'=> 'Update Success...',
                'status' => 200,
            ],200);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ],500);
        }
    }
     /**
     * Delete a customer
     * Delete - api/customer/{id}
     * @param mixed id(customer)
     */
    public function destroy($id){
        try{
            $customer =  Customer::find($id);
            if(!$customer){
                return response()->json([
                    'message' => 'Customer Not Found!!!',
                    'status' => 404,
                ],404);
            }
            $customer->delete();
            return $customer;
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ],500);
        }
    }


}
