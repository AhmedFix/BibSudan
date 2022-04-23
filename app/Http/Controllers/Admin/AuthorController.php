<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuthorRequest;
use App\Models\Author;
use App\Models\Role;
use Yajra\DataTables\DataTables;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_authors')->only(['index']);
        $this->middleware('permission:create_authors')->only(['create', 'store']);
        $this->middleware('permission:update_authors')->only(['edit', 'update']);
        $this->middleware('permission:delete_authors')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        if (request()->ajax()) {
            $authors = Author::where('name', 'like', '%' . request()->search . '%')
                ->limit(10)
                ->get();

            $results = [];

            $results[] = ['id' => '', 'text' => 'All Authors'];

            foreach ($authors as $author) {

                $results[] = ['id' => $author->id, 'text' => $author->name];

            }//end of for each

            return json_encode($results);

        }//end of if

        return view('admin.authors.index');

    }// end of index

    public function create()
    {
        return view('admin.authors.create');

    }//end of create

    public function store(AuthorRequest $request)
    {
        $requestData = $request->validated();

        if ($request->image) {
            $name = $request->image->hashName();
            $request->image->move('uploads/authors_images',$name);
            $requestData['image'] = $name;

        }//end of if 
       
        Author::create($requestData);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('admin.authors.index');

    }// end of store

    public function edit(Author $author)
    {
        $roles = Role::whereNotIn('name', ['super_admin', 'admin'])->get();

        return view('admin.authors.edit', compact('author', 'roles'));

    }// end of edit

    public function update(AuthorRequest $request, Author $author)
    {
        $author->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('admin.authors.index');

    }// end of update


    public function data()
    {
        $authors = Author::withCount(['books']);

        return DataTables::of($authors)
            ->addColumn('record_select', 'admin.authors.data_table.record_select')
            ->addColumn('related_books', 'admin.authors.data_table.related_books')
            ->addColumn('image', function (Author $author) {
                return view('admin.authors.data_table.image', compact('author'));
            })
            ->editColumn('created_at', function (Author $author) {
                return $author->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.authors.data_table.actions')
            ->rawColumns(['record_select', 'image', 'related_books', 'actions'])
            ->toJson();

    }// end of data

    public function destroy(Author $author)
    {
        $this->delete($author);
        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $author = Author::FindOrFail($recordId);
            $this->delete($author);

        }//end of for each

        session()->flash('success', __('site.deleted_successfully'));
        return response(__('site.deleted_successfully'));

    }// end of bulkDelete

    private function delete(Author $author)
    {
        $author->delete();

    }// end of delete

}//end of controller
