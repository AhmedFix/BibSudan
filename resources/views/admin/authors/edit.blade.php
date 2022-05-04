@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('authors.authors')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.authors.index') }}">@lang('authors.authors')</a></li>
        <li class="breadcrumb-item">@lang('site.edit')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <form method="post" action="{{ route('admin.authors.update', $author->id) }}">
                    @csrf
                    @method('put')

                    @include('admin.partials._errors')

                    {{--name--}}
                    <div class="form-group">
                        <label>@lang('authors.name') <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $author->name) }}" required>
                    </div>
                    {{--image--}}
                    <div class="form-group">
                        <label>@lang('authors.image')</span></label>
                        <input type="file" name="image" class="form-control load-image" >
                        <img src="{{ $author->image_path }}" class="loaded-image" alt="" style="display: block; width: 200px; margin: 10px 0;">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.update')</button>
                    </div>

                </form><!-- end of form -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->

@endsection

