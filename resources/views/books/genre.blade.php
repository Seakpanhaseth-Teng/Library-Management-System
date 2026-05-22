@extends('layouts.app')

@section('title', $genre . ' Books')

@section('content')
    <h1 class="text-center mb-4">{{ $genre }} Books</h1>

    @if($books->isEmpty())
        <p class="text-center mt-4">No {{ strtolower($genre) }} books in the library.</p>
    @else
        <div class="row">
            @foreach ($books as $book)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">by {{ $book->author }}</h6>
                            <p class="card-text">
                                <strong>Publisher:</strong> {{ $book->publisher }}<br>
                                <strong>Published Year:</strong> {{ $book->publication_year }}<br>
                                <strong>Pages:</strong> {{ $book->pages }}<br>
                                <strong>Shelf Location:</strong> {{ $book->shelf_location }}<br>
                                <strong>Available Copies:</strong> {{ $book->available_copies }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $books->links() }}
        </div>
    @endif

    <div class="d-flex justify-content-center mt-4 mb-5">
        <a href="{{ url('/all/books') }}" class="btn btn-outline-primary">Back to All Books</a>
    </div>
@endsection