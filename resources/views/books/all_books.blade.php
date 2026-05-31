@extends('layouts.app')

@section('title', 'All Books')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-900">All Books</h1>
        @can('manage-books')
            <a href="{{ url('/createbook') }}"
               class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Book
            </a>
        @endcan
    </div>

    {{-- Search --}}
    <form action="{{ url('/books/search') }}" method="GET" class="flex gap-2">
        <div class="flex-1">
            <input type="text" name="q" placeholder="Search by title, author, or ISBN..."
                   value="{{ request('q') }}"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
        </div>
        <button type="submit"
                class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </button>
    </form>

    {{-- Books Table --}}
    @if($books->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p class="text-gray-500 text-lg">No books found.</p>
            @if(request('q'))
                <p class="text-gray-400 text-sm mt-1">Try a different search term.</p>
            @endif
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publisher</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shelf</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Copies</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            @can('manage-books')
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($books as $index => $book)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $books->firstItem() + $index }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ url('/books/' . $book->id) }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">
                                    {{ $book->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $book->author }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->publisher }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->publication_year }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-50 text-primary-700">
                                    {{ $book->genre }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->shelf_location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">{{ $book->available_copies }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $book->is_available ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                    {{ $book->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>
                            @can('manage-books')
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ url('/books/' . $book->id . '/edit') }}" class="text-primary-600 hover:text-primary-800 mr-3">Edit</a>
                                    <form action="{{ url('/books/' . $book->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this book?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-center mt-4">
            {{ $books->links() }}
        </div>
    @endif

    {{-- Filter Buttons --}}
    <div class="flex flex-wrap gap-2">
        <a href="{{ url('/books/fiction') }}"
           class="inline-flex items-center px-4 py-2 bg-primary-50 text-primary-700 text-sm font-medium rounded-lg hover:bg-primary-100 transition-colors">
            Fiction
        </a>
        <a href="{{ url('/books/nonfiction') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
            Non-Fiction
        </a>
        <a href="{{ url('/books/available') }}"
           class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 text-sm font-medium rounded-lg hover:bg-green-100 transition-colors">
            Available
        </a>
        <a href="{{ url('/all/books') }}"
           class="inline-flex items-center px-4 py-2 bg-white text-gray-500 text-sm font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition-colors">
            All Books
        </a>
    </div>
</div>
@endsection
