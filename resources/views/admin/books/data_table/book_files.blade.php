@if ($book->pdf_url != null)
<a href="{{  $book->pdf_url }}" target="_blank" class="btn btn-success btn-sm"> @lang('books.download_pdf')</a>
@endif
