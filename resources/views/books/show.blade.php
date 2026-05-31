@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ url('/all/books') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-primary-600 mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to All Books
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="md:flex">
            {{-- Cover Image --}}
            <div class="md:w-72 bg-gray-50 p-8 flex items-center justify-center">
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                        class="w-full max-w-[200px] rounded-lg shadow-md">
                @else
                    <div class="w-48 h-64 bg-gradient-to-br from-primary-100 to-primary-200 rounded-lg flex items-center justify-center shadow-md">
                        <div class="text-center p-4">
                            <svg class="w-12 h-12 text-primary-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span class="text-xs text-primary-500">No Cover</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Book Details --}}
            <div class="flex-1 p-6 md:p-8">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $book->title }}</h1>
                        <p class="text-lg text-gray-600 mt-1">by {{ $book->author }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $book->is_available ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                        {{ $book->is_available ? 'Available' : 'Unavailable' }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">ISBN</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $book->isbn }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Genre</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $book->genre }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Publisher</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $book->publisher }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Year</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $book->publication_year }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Pages</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $book->pages }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Shelf</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $book->shelf_location }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3 col-span-2">
                        <p class="text-xs text-gray-500 uppercase tracking-wide">Available Copies</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">{{ $book->available_copies }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 mt-6">
                    @can('manage-books')
                        <a href="{{ url('/books/' . $book->id . '/edit') }}"
                           class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Book
                        </a>
                        <form action="{{ url('/books/' . $book->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this book?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    @endcan
                    @can('borrow-books')
                        @if($book->is_available && $book->available_copies > 0)
                            <a href="{{ route('borrowings.create', ['book_id' => $book->id]) }}"
                               class="inline-flex items-center px-4 py-2 bg-accent-500 text-white text-sm font-medium rounded-lg hover:bg-accent-600 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Borrow This Book
                            </a>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
