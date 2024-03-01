<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookReviewController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



//create a customer
Route::post('customer', [CustomerController::class,'store']);
//update a customer
Route::post('customer/{id}', [CustomerController::class, 'update']);
//read customers
Route::get('customers', [CustomerController::class, 'index']);
//delete a customer
Route::delete('customer/{id}', [CustomerController::class, 'destroy']);

//create a book
Route::post('book', [BookController::class, 'store']);
//update a book
Route::post('book/{id}', [BookController::class, 'update']);
//read books
Route::get('books', [BookController::class, 'index']);
//delete a book
Route::delete('book/{id}', [BookController::class, 'destroy']);

//Create a order
Route::post('order/{id}', [OrderController::class, 'store']);
//Update a order
Route::post('orderUpdate/{id}/{orderId}/{orderDetailId}', [OrderController::class, 'update']);
//Delete a orderDetail
Route::delete('order/{id}/{orderId}/{orderDetailId}', [OrderController::class, 'destroy']);
//Read Order
Route::get('orders', [OrderController::class, 'index']);
//Read OrderDeatil
Route::get('order/{orderId}', [OrderController::class, 'show']);

//create a bookreview
Route::post('bookReview', [BookReviewController::class, 'store']);
//update a bookreview
Route::post('bookReview/{id}', [BookReviewController::class, 'update']);
//delete a bookreview
Route::delete('bookReview/{id}', [BookReviewController::class, 'destroy']);
//read a bookreview
Route::get('bookReviews', [BookReviewController::class, 'index']);


