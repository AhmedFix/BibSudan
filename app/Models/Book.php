<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [ 'title', 'description', 'poster', 'pdf', 'release_date', 'vote',
        'vote_count','page_count', 'type'
    ];

    protected $appends = ['poster_path','pdf_path',];

    // protected $casts = [
    //     'release_date' => 'date',
    // ];

    //attr
    public function getPosterPathAttribute()
    {
        if ($this->poster) {
            return asset('uploads/books_images/' . $this->poster);
            // return Storage::url('app/uploads/books_images/' . $this->poster);
        }

        return asset('uploads/books_images/default.png');
        
    }// end of getPosterPathAttribute

    public function getPdfPathAttribute()
    {
            return asset('uploads/books_files/' . $this->pdf);
       
        
    }// end of getPdfPathAttribute

    //scope

    public function scopeWhenAuthorId($query, $authorId)
    {
        return $query->when($authorId, function ($q) use ($authorId) {

            return $q->whereHas('authors', function ($qu) use ($authorId) {

                return $qu->where('authors.id', $authorId);

            });

        });

    }// end of scopeWhenAuthorId


    public function scopeWhenCategoryId($query, $categoryId)
    {
        return $query->when($categoryId, function ($q) use ($categoryId) {

            return $q->whereHas('categories', function ($qu) use ($categoryId) {

                return $qu->where('categories.id', $categoryId);

            });

        });

    }// end of scopeWhenCategoryId

    public function scopeWhenType($query, $type)
    {
        return $query->when($type, function ($q) use ($type) {

            if ($type == 'popular') {
                return $q->where('type', null);
            }

            return $q->where('type', $type);

        });

    }// end of scopeWhenType

    public function scopeWhenSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {

            return $q->where('title', 'like', '%' . $search . '%');

        });

    }// end of scopeWhenSearch

    //rel
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');

    }// end of categories

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');

    }// end of authors

    public function images()
    {
        return $this->hasMany(Image::class);

    }// end of images

    public function favoriteByUsers()
    {
        return $this->belongsToMany(User::class, 'user_favorite_book', 'book_id', 'user_id');

    }// end of favouriteByUsers

    //fun
    public function hasPoster()
    {
        return $this->poster != null;

    }// end of hasPoster

    public function hasPdf()
    {
        return $this->pdf != null;

    }// end of haspdf

}//end of model
