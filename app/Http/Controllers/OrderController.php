<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Book;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Read Orders
     * Get - api/orders
     */
    public function index(){
        try{
            $orders = Order::all();
                 return response()->json([
                     'orders'=> $orders,
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
     * Read Order Detail
     * Get - api/order/{orderId}
     * @param mixed orderId
     */
    public function show($id){
        try{
           $orderDetail = OrderDetail::where('order_id',$id)->first();
                return response()->json([
                     'orders'=> $orderDetail,
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
     * Create a Order
     * Post - api/order/{id}(customer)
     * @param mixed book_id,qty
     */
    public function store($id,Request $request){
        try{
            $customer_id =  Customer::find($id);
            $customer_id = $customer_id->id;
           $order = Order::create([
                'customer_id' => $customer_id,
                'date' => Carbon::now()
            ]);
           $orderDetail = OrderDetail::create([
                'book_id'=> $request->book_id,
                'order_id'=> $order->id,
                'qty'=>$request->qty,
            ]);
            $book = Book::where('id',$request->book_id)->first();
            if(!$book){
                return response()->json([
                    'message' => 'Book Not Found!!!',
                    'status' => 404,
                ],404);
            }
            $order->update([
            'amount'=> $orderDetail->qty * $book->price,
            ]);
            return response()->json([
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
     * Update a Order
     * Post - api/order/{id}(customer)/{orderId}(order)/{orderDetailId}
     * @param mixed book_id,qty
     */
    public function update($id,$orderId,$orderDetailId,Request $request){
        try{
            $customer_id =  Customer::find($id);
            $customer_id = $customer_id->id;
            $order = Order::find($orderId);
            if($order->customer_id != $customer_id){
                return response()->json([
                    'message'=> 'You can not change this order bcoz you not own for this order...',
                    'status'=>403,
                ],403);
            }
           $order->update([
                'customer_id' => $customer_id,
                'date' => Carbon::now()
            ]);
            $orderDetail = OrderDetail::find($orderDetailId);
            $orderDetail->update([
                'book_id'=> $request->book_id,
                'order_id'=> $order->id,
                'qty'=>$request->qty,
            ]);
            $book = Book::where('id',$request->book_id)->first();
            if(!$book){
                return response()->json([
                    'message' => 'Book Not Found!!!',
                    'status' => 404,
                ],404);
            }

            $order->update([
            'amount'=> $orderDetail->qty * $book->price,
            ]);
            return response()->json([
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
     * Delete a OrderDetail
     * Post - api/order/{id}(customer)/{orderId}(order)/{orderDetailId}
     */
    public function destroy($id,$orderId,$orderDetailId){
        try{

            $customer_id =  Customer::find($id);
            $customer_id = $customer_id->id;
            $order = Order::where('id',$orderId)->first();
            if($order->customer_id == $customer_id){
              $orderDetail =  OrderDetail::where('id', $orderDetailId)->first();
            $orderDetail->delete();
            $order->delete();
            return $orderDetail;
            }
            return response()->json([
                'message'=> 'You can not delete this order bcoz you not own for this order...',
                'status'=>403,
            ],403);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ],500);
        }

    }
}
