<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'image'];

    protected $appends = ['image_path'];

    // attr
    public function getImagePathAttribute()
    {
        if ($this->image) {
            return 'https://image.tmdb.org/t/p/w500' . $this->image;
        }

    }// end of getImagePathAttribute

    //scope

    //rel
    public function book()
    {
        return $this->belongsTo(Book::class);

    }// end of book

    //fun

}//end of model
