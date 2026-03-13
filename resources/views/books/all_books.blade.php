<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            overflow-y: auto; /* Enable vertical scrolling */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Library Books</h1>
        <div class="table-responsive border p-3 rounded">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Published Year</th>
                        <th>Genre</th>
                        <th>Pages</th>
                        <th>Shelf Location</th>
                        <th>Available Copies</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $index => $book)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->publication_year }}</td>
                        <td>{{ $book->genre }}</td>
                        <td>{{ $book->pages }}</td>
                        <td>{{ $book->shelf_location }}</td>
                        <td>{{ $book->available_copies }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($books->isEmpty())
            <p class="text-center mt-4">No books available in the library.</p>
        @endif
        <div class="d-flex justify-content-between mt-4 mb-5">
            <a href="{{ url('/books/fiction') }}" class="btn btn-primary">Fiction</a>
            <a href="{{ url('/books/nonfiction') }}" class="btn btn-secondary">Non-Fiction</a>
        </div>
    </div>
</body>
</html>