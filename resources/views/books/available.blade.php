@extends('layouts.app')

@section('title', 'Available Books')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-900">Available Books</h1>

    @if($books->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500">No available books at the moment.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($books as $book)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 truncate">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">by {{ $book->author }}</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ml-3">
                            {{ $book->available_copies }} copies
                        </span>
                    </div>
                    <div class="mt-3 flex items-center gap-2">
                        <a href="{{ url('/books/' . $book->id) }}"
                           class="text-sm text-primary-600 hover:text-primary-800 font-medium">View Details</a>
                        @can('borrow-books')
                            <a href="{{ route('borrowings.create', ['book_id' => $book->id]) }}"
                               class="text-sm text-accent-600 hover:text-accent-800 font-medium">Borrow</a>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center mt-4">
            {{ $books->links() }}
        </div>
    @endif

    <div class="flex justify-center">
        <a href="{{ url('/all/books') }}" class="text-gray-500 hover:text-primary-600 text-sm font-medium">
            &larr; Back to All Books
        </a>
    </div>
</div>
@endsection
