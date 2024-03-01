<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['ISBN', 'author', 'title', 'price', 'cover_url'];

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function bookReviews(){
        return $this->hasMany(BookReview::class);
    }
}
