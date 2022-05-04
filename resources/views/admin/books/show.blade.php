@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('books.books')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">@lang('books.books')</a></li>
        <li class="breadcrumb-item">@lang('site.show')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <div class="row">
                    <div class="col-md-2">
                        <img src="{{ $book->poster_path }}" class="img-fluid" alt="">
                    </div>

                    <div class="col-md-10">
                        <h2>{{ $book->title }}</h2>

                        @foreach ($book->categories as $category)
                            <h5 class="d-inline-block"><span class="badge badge-primary">{{ $category->name }}</span></h5>
                        @endforeach

                        <p style="font-size: 16px;">{{ $book->description }}</p>

                        <div class="d-flex mb-2">
                            <i class="fa fa-star text-warning" style="font-size: 24px;"></i>
                            <h3 class="m-0 mx-2">{{ $book->vote }}</h3>
                            <p class="m-0 align-self-center">@lang('books.vot_by') {{ $book->vote_count }}</p>
                        </div>

                        <p><span class="font-weight-bold">@lang('books.language')</span>: en</p>
                        <p><span class="font-weight-bold">@lang('books.release_date')</span>: {{ $book->release_date }}</p>

                        <hr>

                        <div class="row" id="book-images">

                            @foreach ($book->images as $image)

                                <div class="col-md-3 my-2">
                                    <a href="{{ $image->image_path }}"><img src="{{ $image->image_path }}" class="img-fluid" alt=""></a>
                                </div><!-- end of col -->
                            @endforeach
                            @if ($book->pdf_url != null)
                                 <a href="{{  $book->pdf_url }}" target="_blank" class="btn btn-success btn-sm"> @lang('books.download_pdf')</a>
                            @endif

                        </div><!-- end of row -->

                        <hr>

                        <div class="row">

                            @foreach ($book->authors as $author)

                                <div class="col-md-2 my-2">
                                    <a href="{{ route('admin.books.index', ['author_id' => $author->id]) }}">
                                        <img src="{{ $author->image_path }}" class="app-sidebar__user-avatar" alt="">
                                    </a>
                                    <a href="{{ route('admin.books.index', ['author_id' => $author->id]) }}">
                                        <label>@lang('authors.author') : {{ $author->name }}</label>
                                    </a>    
                                </div><!-- end of col -->

                            @endforeach

                        </div><!-- end of row -->

                    </div><!-- end of col  -->

                </div><!-- end of row -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->

@endsection

@push('scripts')

    <script>
        $(function () {

            $('#book-images').magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled: true
                }
            });

        });//end of document ready

    </script>
@endpush

