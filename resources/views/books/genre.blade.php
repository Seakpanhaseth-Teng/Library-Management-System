@extends('layouts.app')

@section('title', $genre . ' Books')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-900">{{ $genre }} Books</h1>

    @if($books->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p class="text-gray-500">No {{ strtolower($genre) }} books in the library.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($books as $book)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-500 mt-1">by {{ $book->author }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $book->is_available ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }} ml-3">
                                {{ $book->available_copies }} copies
                            </span>
                        </div>
                        <div class="mt-3 grid grid-cols-2 gap-x-4 gap-y-1 text-sm text-gray-500">
                            <span>Publisher: <strong class="text-gray-700">{{ $book->publisher }}</strong></span>
                            <span>Year: <strong class="text-gray-700">{{ $book->publication_year }}</strong></span>
                            <span>Pages: <strong class="text-gray-700">{{ $book->pages }}</strong></span>
                            <span>Shelf: <strong class="text-gray-700">{{ $book->shelf_location }}</strong></span>
                        </div>
                        <div class="mt-3">
                            <a href="{{ url('/books/' . $book->id) }}" class="text-sm text-primary-600 hover:text-primary-800 font-medium">
                                View Details &rarr;
                            </a>
                        </div>
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
