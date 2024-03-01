<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{

    /**
     * Read books
     * Get - api/books
     */
    public function index(){
        try{
       $books = Book::all();
        return response()->json([
                'books'=> $books,
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
     * Create a book
     * Post - api/book
     * @param mixed isbn,title,author,price,cover_url
     */
    public function store(Request $request){
        try{
            $validation = Validator::make($request->all(), [
                'ISBN' => 'required',
                'title' => 'required',
                'author' => 'required',
                'price' => 'required',
                'cover_url' => 'required|mimes:jpeg,png,jpg|file',
            ]);

            if($validation->fails()){
                return response()->json([
                    'ErrorMessage'=> $validation->errors(),
                    'status'=>400
                ],400);
            }

            $fileName = $request->cover_url->getClientOriginalName();
            $request->cover_url->storeAs('public/'.$fileName);
            $book = Book::create([
                'ISBN' => $request->ISBN,
                'title' => $request->title,
                'author' => $request->author,
                'price' => $request->price,
                'cover_url'=>$fileName,
            ]);
            return response()->json([
                'data' => $book,
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
     * Update a book
     * Post - api/book/{id}
     * @param mixed isbn,title,author,price,cover_url,id(book)
     */
    public function update($id,Request $request){
        try{
            $book  = Book::find($id);
            if(!$book){
                return response()->json([
                    [
                        'message' => "Book Not Found!!!",
                        'status' => 404,
                    ]
                ], 404);
            }
            $validation = Validator::make($request->all(), [
                'ISBN' => 'required',
                'title' => 'required',
                'author' => 'required',
                'price' => 'required',
                'cover_url' => 'required|mimes:jpeg,png,jpg|file',
            ]);

            if($validation->fails()){
                return response()->json([
                    'ErrorMessage'=> $validation->errors(),
                    'status'=>400
                ],400);
            }
            $fileName = $request->cover_url->getClientOriginalName();
            $request->cover_url->storeAs('public/'.$fileName);
            $book->update([
                'ISBN' => $request->ISBN,
                'title' => $request->title,
                'author' => $request->author,
                'price' => $request->price,
                'cover_url'=>$fileName,
            ]);

            return response()->json([
                'data' => $book,
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
            $book =  Book::find($id);
            if(!$book){
                return response()->json([
                    'message' => 'Book Not Found!!!',
                    'status' => 404,
                ],404);
            }
            $book->delete();
            return $book;
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 500,
            ],500);
        }
    }
}
