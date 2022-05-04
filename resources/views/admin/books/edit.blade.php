@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('books.books')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">@lang('books.books')</a></li>
        <li class="breadcrumb-item">@lang('site.edit')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <form method="post" action="{{ route('admin.books.update', $book->id) }}">
                    @csrf
                    @method('put')

                    @include('admin.partials._errors')

                    {{--title--}}
                    <div class="form-group">
                        <label>@lang('books.title') <span class="text-danger">*</span></label>
                        <input type="text" name="title" autofocus class="form-control" value="{{ $book->title }}" required>
                    </div>
                    {{--description--}}
                    <div class="form-group">
                        <label>@lang('books.description') <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" required>{{ $book->description }}</textarea>
                    </div>
                    
                    {{--poster--}}
                    <div class="form-group">
                        <label>@lang('books.poster')</span></label>
                        <input type="file" name="poster" class="form-control load-image" >
                        <img src="{{ $book->poster_path }}" class="loaded-image" alt="" style="display: block; width: 200px; margin: 10px 0;">
                    </div>
                   {{--pdf--}}
                   <div class="form-group">
                   <label>@lang('books.pdf') <span class="text-danger">*</span></label>
                   <input type="file" name="pdf" class="form-control load-image" >
                   </div>
                   {{--page count--}}
                    <div class="form-group">
                    <label>@lang('books.page_count') <span class="text-danger">*</span></label>
                    <input type="text" name="page_count" autofocus class="form-control" value="{{ $book->page_count }}" required>
                    </div>
                    {{-- categories --}}
                    <div class="form-group">
                        <label>@lang('books.categories')<span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control" required>
                            <option value="">@lang('books.all_categories')</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- authors --}}
                    <div class="form-group">
                        <label>@lang('books.authors')<span class="text-danger">*</span></label>
                        <select name="author_id" class="form-control" required>
                            <option value="">@lang('books.all_authors')</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}" >{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                     {{--type--}}
                     <div class="form-group">
                        @php
                        $models = ['books', 'novels', 'stories'];
                        @endphp
                        <label>@lang('books.type') <span class="text-danger">*</span></label>
                        <select name="type" class="form-control select2" required>
                            <option value="">@lang('site.choose') @lang('books.type')</option>
                            @foreach ($models as $model)
                                <option value="{{ $model }}" {{ $model == $book->type ? 'selected' : '' }}>{{ $model }}</option>
                            @endforeach
                        </select>
                    </div>

                 {{-- Date  --}}
                 <div class="form-group">
                    <label>@lang('books.release_date') <span class="text-danger">*</span></label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="text" name="release_date" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{ $book->release_date }}" required/>
                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                       <!-- /.input group -->
                  </div>
                   <!-- /.form group --> 



                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.update')</button>
                    </div>

                </form><!-- end of form -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->

@endsection

