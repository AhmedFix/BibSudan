@extends('layouts.admin.app')

@section('content')

    <div>
        <h2>@lang('books.books')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item">@lang('books.books')</li>
    </ul>

    <div class="row">

        <div class="col-md-12">

            <div class="tile shadow">

                <div class="row mb-2">

                    <div class="col-md-12">

                        @if (auth()->user()->hasPermission('read_books'))
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.create')</a>
                        @endif

                        @if (auth()->user()->hasPermission('delete_books'))
                            <form method="post" action="{{ route('admin.books.bulk_delete') }}" style="display: inline-block;">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="record_ids" id="record-ids">
                                <button type="submit" class="btn btn-danger" id="bulk-delete" disabled="true"><i class="fa fa-trash"></i> @lang('site.bulk_delete')</button>
                            </form><!-- end of form -->
                        @endif

                    </div>

                </div><!-- end of row -->

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" id="data-table-search" class="form-control" autofocus placeholder="@lang('site.search')">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <select id="category" class="form-control select2" required>
                                <option value="">@lang('site.all') @lang('categories.categories')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == request()->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <select id="author" class="form-control select2" required>
                                <option value="">@lang('site.all') @lang('authors.authors')</option>
                                @if ($author)
                                    <option value="{{ $author->id }}" {{ $author->id == request()->author_id ? 'selected' : '' }}>{{ $author->name }}</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <select id="type" class="form-control select2" required>
                                <option value="">@lang('site.all') @lang('books.books')</option>
                                @foreach (['novels', 'stories'] as $type)
                                    <option value="{{ $type }}" {{ $type == request()->type ? 'selected' : '' }}>@lang('books.' . $type)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div><!-- end of row -->

                <div class="row">

                    <div class="col-md-12">

                        <div class="table-responsive">

                            <table class="table datatable" id="books-table" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="animated-checkbox">
                                            <label class="m-0">
                                                <input type="checkbox" id="record__select-all">
                                                <span class="label-text"></span>
                                            </label>
                                        </div>
                                    </th>
                                    <th>@lang('books.poster')</th>
                                    <th>@lang('books.title')</th>
                                    <th>@lang('books.pdf')</th>
                                    <th>@lang('categories.categories')</th>
                                    <th>@lang('authors.authors')</th>
                                    <th>@lang('books.vote')</th>
                                    <th>@lang('books.vote_count')</th>
                                    <th>@lang('books.release_date')</th>
                                    <th>@lang('books.favourite_by')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                                </thead>
                            </table>

                        </div><!-- end of table responsive -->

                    </div><!-- end of col -->

                </div><!-- end of row -->

            </div><!-- end of tile -->

        </div><!-- end of col -->

    </div><!-- end of row -->

@endsection

@push('scripts')

    <script>

        let category = "{{ request()->category_id }}";
        let author = "{{ request()->author_id }}";
        let type = "{{ request()->type }}";

        let booksTable = $('#books-table').DataTable({
            dom: "tiplr",
            serverSide: true,
            processing: true,
            "language": {
                "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
            },
            ajax: {
                url: '{{ route('admin.books.data') }}',
                data: function (d) {
                    d.category_id = category;
                    d.author_id = author;
                    d.type = type;
                }
            },
            columns: [
                {data: 'record_select', name: 'record_select', searchable: false, sortable: false, width: '1%'},
                {data: 'poster', name: 'poster', searchable: false, sortable: false, width: '10%'},
                {data: 'title', name: 'title', width: '15%'},
                {data: 'pdf', name: 'pdf', width: '15%'},
                {data: 'categories', name: 'categories', searchable: false},
                {data: 'authors', name: 'authors', searchable: false},
                {data: 'vote', name: 'vote', searchable: false},
                {data: 'vote_count', name: 'vote_count', searchable: false},
                {data: 'release_date', name: 'release_date', searchable: false},
                {data: 'favorite_by_users_count', name: 'favorite_by_users_count', searchable: false},
                {data: 'actions', name: 'actions', searchable: false, sortable: false, width: '20%'},
            ],
            order: [[5, 'desc']],
            drawCallback: function (settings) {
                $('.record__select').prop('checked', false);
                $('#record__select-all').prop('checked', false);
                $('#record-ids').val();
                $('#bulk-delete').attr('disabled', true);
            }
        });

        $('#category').on('change', function () {
            category = this.value;
            booksTable.ajax.reload();
        })

        $('#author').on('change', function () {
            author = this.value;
            booksTable.ajax.reload();
        })

        $('#type').on('change', function () {
            type = this.value;
            booksTable.ajax.reload();
        })

        $('#data-table-search').keyup(function () {
            booksTable.search(this.value).draw();
        })

        $('#author').select2({
            ajax: {
                url: "{{ route('admin.authors.index') }}",
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term,
                    }
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                }
            }
        });

    </script>

@endpush