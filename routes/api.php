<?php
use Illuminate\Support\Facades\Route;

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');

//category  routes
Route::get('/categories', 'CategoryController@index');

//author  routes
Route::get('/authors', 'AuthorController@index');

//book routes
Route::get('/books/{book}/images', 'BookController@images');
Route::get('/books/{book}/actors', 'BookController@actors');
Route::get('/books/{book}/related_books', 'BookController@relatedBooks');
Route::get('/books', 'BookController@index');

Route::middleware('auth:sanctum')->group(function () {

    //book routes
    Route::get('/books/toggle_book', 'BookController@toggleFavorite');

    //user route
    Route::get('/user', 'AuthController@user');
});