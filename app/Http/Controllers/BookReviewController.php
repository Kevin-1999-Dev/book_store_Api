<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Book;
use App\Models\BookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookReviewController extends Controller
{
     /**
     * Read bookReviews
     * Get - api/bookReviews
     */
    public function index(){
        try{
       $bookReviews = BookReview::all();
            return response()->json([
                'bookReviews'=> $bookReviews,
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
     * Create Book Review
     * Post - api/bookReview
     * @param mixed book_id,description
     */
    public function store(Request $request){
        try{
            $validation = Validator::make($request->all(), [
                'book_id' => 'required',
                'description' => 'required|max:255',
            ]);

            if($validation->fails()){
                return response()->json([
                    'ErrorMessage'=> $validation->errors(),
                    'status'=>400
                ],400);
            }
            $bookReview = BookReview::create([
                'book_id' => $request->book_id,
                'description' => $request->description,
            ]);
            return response()->json([
                'data' => $bookReview,
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
     * Update Book Review
     * Post - api/bookReview/{id}(bookReview)
     * @param mixed book_id,description
     */
    public function update(Request $request,$id){
        try{
            $bookReview  = BookReview::find($id);
            if(!$bookReview){
                return response()->json([
                    [
                        'message' => "This Review Not Found!!!",
                        'status' => 404,
                    ]
                ], 404);
            }
            $validation = Validator::make($request->only('description'), [
                'description' => 'required|max:255',
            ]);

            if($validation->fails()){
                return response()->json([
                    'ErrorMessage'=> $validation->errors(),
                    'status'=>400
                ],400);
            }
          $book =  Book::find($request->book_id);
            if(!$book){
                return response()->json([
                    [
                        'message' => "This Book Id Not Found!!!",
                        'status' => 404,
                    ]
                ], 404);
            }
            $bookReview->update([
                'book_id' => $request->book_id,
                'description' => $request->description,
            ]);
            return response()->json([
                'data' => $bookReview,
                'message'=> 'Updated Success...',
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
     * Delete a bookReview
     * Delete - api/bookReview/{id}
     * @param mixed id(bookReview)
     */
    public function destroy($id){
        try{
            $bookReview =  BookReview::find($id);
            if(!$bookReview){
                return response()->json([
                    'message' => 'This Review Not Found!!!',
                    'status' => 404,
                ],404);
            }
            $bookReview->delete();
            return $bookReview;
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ],500);
        }
    }


}
