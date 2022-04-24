@if ($book->pdf_path != null)
<a href="{{ asset('uploads/books_files/'  . $book->pdf)}}" target="_blank" class="btn btn-success btn-sm"> @lang('books.download_pdf')</a>
@endif
