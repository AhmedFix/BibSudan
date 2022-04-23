@foreach ($book->authors as $author)
    <h5><span class="badge badge-primary">{{ $author->name }}</span></h5>
@endforeach
