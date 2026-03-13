<h1 class="text-center my-4">Available Books</h1>
<div class="container">
    <ul class="list-group">
        @foreach ($books as $book)
            <li class="list-group-item">
                <strong>Title:</strong> {{ $book->title }}
            </li>
        @endforeach
    </ul>
</div>