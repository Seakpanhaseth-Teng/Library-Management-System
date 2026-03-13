<!DOCTYPE html>
<html>
<head>
    <title>Library Books</title>
</head>
<body>
    <h1>Books</h1>
    <ul>
        @foreach ($books as $book)
            <li>
                <strong>{{ $book->title }}</strong> - {{ $book->author }} 
                ({{ $book->genre }}) - 
                {{ $book->is_available ? 'Available' : 'Unavailable' }}
            </li>
        @endforeach
    </ul>
</body>
</html>