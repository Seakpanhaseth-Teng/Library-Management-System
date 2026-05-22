@extends('layouts.app')

@section('title', 'Available Books')

@section('content')
    <h1 class="text-center mb-4">Available Books</h1>

    <ul class="list-group mb-4">
        @foreach ($books as $book)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $book->title }}</strong>
                    <span class="text-muted ms-2">by {{ $book->author }}</span>
                </div>
                <span class="badge bg-success rounded-pill">{{ $book->available_copies }} copies</span>
            </li>
        @endforeach
    </ul>

    @if($books->isEmpty())
        <p class="text-center mt-4">No available books at the moment.</p>
    @endif

    <div class="d-flex justify-content-center mt-3">
        {{ $books->links() }}
    </div>

    <div class="d-flex justify-content-center mt-4 mb-5">
        <a href="{{ url('/all/books') }}" class="btn btn-outline-primary">Back to All Books</a>
    </div>
@endsection
