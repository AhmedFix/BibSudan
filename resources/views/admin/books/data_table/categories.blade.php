@foreach ($book->categories as $category)
    <h5><span class="badge badge-primary">{{ $category->name }}</span></h5>
@endforeach
