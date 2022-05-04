<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_books')->only(['index']);
        $this->middleware('permission:create_books')->only(['create', 'store']);
        $this->middleware('permission:update_books')->only(['edit', 'update']);
        $this->middleware('permission:delete_books')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $categories = Category::all();

        $author = null;

        if (request()->author_id) {
            $author = Author::find(request()->author_id);
        }

        return view('admin.books.index', compact('author', 'categories'));

    }// end of index

    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();
        return view('admin.books.create', compact('categories', 'authors'));

    }//end of create

    public function store(BookRequest $request)
    {
         
        $requestData = $request->validated();
        if ($request->poster) {
            $name = $request->poster->hashName();
            $request->poster->move('uploads/books_images',$name);
            $requestData['poster'] = $name;

        }//end of if
        
        // $requestData = $request->except(['category_id', 'author_id']);
        $requestData['release_date'] = date('Y-m-d H:i:s');
        $requestData['vote'] = '0.0';
        $requestData['vote_count'] = '0.0';
        $book = Book::create($requestData);


        ///
        $category =Category::find($request->category_id);
        $category->books()->attach($book->id);
        $author =Author::find($request->author_id);
        $author->books()->attach($book->id);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.books.index');

    }// end of store

    public function edit(Book $book)
    {
        $roles = Role::whereNotIn('name', ['super_admin', 'admin'])->get();
        $categories = Category::all();
        $authors = Author::all();
        return view('admin.books.edit', compact('book', 'roles','categories', 'authors'));

    }// end of edit

    public function update(BookRequest $request, Book $book)
    {
        $requestData = $request->validated();
        if ($request->poster) {

            if ($book->hasPoster()) {
                Storage::disk('local')->delete('public/uploads/books_images' . $book->poster);
            }

            $request->poster->store('public/uploads/books_images');
            $requestData['poster'] = $request->poster->hashName();

        }//end of if 

        $book->update($requestData);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.books.index');

    }// end of update

    public function data()
    {
        $books = Book::whenCategoryId(request()->Category_id)
            ->whenAuthorid(request()->author_id)
            ->whenType(request()->type)
            ->with(['categories'])
            ->with(['authors'])
            ->withCount(['favoriteByUsers']);

        return DataTables::of($books)
            ->addColumn('record_select', 'admin.books.data_table.record_select')
            ->addColumn('poster', function (Book $book) {
                return view('admin.books.data_table.poster', compact('book'));
            })
            ->addColumn('pdf', function (Book $book) {
                return view('admin.books.data_table.book_files', compact('book'));
            })
            ->addColumn('categories', function (Book $book) {
                return view('admin.books.data_table.categories', compact('book'));
            })
            ->addColumn('authors', function (Book $book) {
                return view('admin.books.data_table.authors', compact('book'));
            })
            ->addColumn('vote', 'admin.books.data_table.vote')
            ->editColumn('created_at', function (Book $book) {
                return $book->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.books.data_table.actions')
            ->rawColumns(['record_select', 'vote', 'actions'])
            ->toJson();

    }// end of data

    public function show(Book $book)
    {
        $book->load(['categories', 'authors', 'images']);

        return view('admin.books.show', compact('book'));

    }// end of show

    public function destroy(Book $book)
    {
        $this->delete($book);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $book = Book::FindOrFail($recordId);
            $this->delete($book);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

    private function delete(Book $book)
    {
        $book->delete();

    }// end of delete

}//end of controller
