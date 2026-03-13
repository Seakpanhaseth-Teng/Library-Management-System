<h1>Non-Fiction Books</h1>
<ul>
    @foreach ($books as $book)
        <li>
            <strong>Title:</strong> {{ $book->title }}<br>
            <strong>Author:</strong> {{ $book->author }}<br>
            <strong>Publisher:</strong> {{ $book->publisher }}<br>
            <strong>Published Year:</strong> {{ $book->publication_year }}<br>
            <strong>Genre:</strong> {{ $book->genre }}<br>
            <strong>Pages:</strong> {{ $book->pages }}<br>
            <strong>Shelf Location:</strong> {{ $book->shelf_location }}<br>
            <strong>Available Copies:</strong> {{ $book->available_copies }}<br>
        </li>
        <hr>
    @endforeach
</ul>