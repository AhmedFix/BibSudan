<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    protected $appends = ['image_path'];

    //attr
    public function getImagePathAttribute()
    {
        if ($this->image) {
            return asset('uploads/authors_images/' . $this->image);
        }

        return asset('uploads/authors_images/default.png');

    }// end of getImagePathAttribute

    //scope

    //rel
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_author');

    }// end of books
    
    //fun
    public function images()
    {
        return $this->hasMany(Image::class);

    }// end of images

}//end of model

