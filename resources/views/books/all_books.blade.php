@extends('layouts.app')

@section('title', 'All Books')

@section('content')
    <h1 class="text-center mb-4">All Books</h1>

    <form action="{{ url('/books/search') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-10">
            <input type="text" name="q" class="form-control" placeholder="Search by title, author, or ISBN..." value="{{ request('q') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Search</button>
        </div>
    </form>

    <div class="table-responsive border p-3 rounded">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Year</th>
                    <th>Genre</th>
                    <th>Pages</th>
                    <th>Shelf</th>
                    <th>Copies</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $index => $book)
                <tr>
                    <td>{{ $books->firstItem() + $index }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->publisher }}</td>
                    <td>{{ $book->publication_year }}</td>
                    <td>{{ $book->genre }}</td>
                    <td>{{ $book->pages }}</td>
                    <td>{{ $book->shelf_location }}</td>
                    <td>{{ $book->available_copies }}</td>
                    <td>
                        <a href="{{ url('/books/' . $book->id . '/edit') }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ url('/books/' . $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this book?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($books->isEmpty())
        <p class="text-center mt-4">No books found.</p>
    @endif

    <div class="d-flex justify-content-center mt-3">
        {{ $books->links() }}
    </div>

    <div class="d-flex flex-wrap justify-content-center gap-2 mt-4 mb-5">
        <a href="{{ url('/books/fiction') }}" class="btn btn-primary">Fiction</a>
        <a href="{{ url('/books/nonfiction') }}" class="btn btn-secondary">Non-Fiction</a>
        <a href="{{ url('/books/available') }}" class="btn btn-success">Available</a>
        <a href="{{ url('/createbook') }}" class="btn btn-warning">+ Add Book</a>
    </div>
@endsection
