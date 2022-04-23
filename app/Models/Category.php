<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    //attr
    protected $guarded = [];
    //scope

    //rel
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_category');

    }// end of books

    //fun

}//end of model
