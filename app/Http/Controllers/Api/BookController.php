<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\BookResource;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::whenType(request()->type)
            ->whenSearch(request()->search)
            ->whenCategoryId(request()->category_id)
            ->whenAuthorId(request()->author_id)
            ->with('categories')
            ->paginate(10);

        $data['books'] = BookResource::collection($books)->response()->getData(true);

        return response()->api($data);

    }// end of index

    public function toggleFavorite()
    {
        auth()->user()->favoriteBooks()->toggle([request()->book_id]);

        return response()->api(null, 0, 'book toggled successfully');

    }// end of toggleFavourite

    public function images(Book $book)
    {
        return response()->api(ImageResource::collection($book->images));

    }// end of images

    public function authors(Book $book)
    {
        return response()->api(AuthorResource::collection($book->authors));

    }// end of authors

    public function relatedBooks(Book $book)
    {
        $books = Book::whereHas('categories', function ($q) use ($book) {
            return $q->whereIn('name', $book->categories()->pluck('name'));
        })
            ->with('categories')
            ->where('id', '!=', $book->id)
            ->paginate(10);

        return response()->api(BookResource::collection($books));

    }// end of relatedBooks

}//end of controller
