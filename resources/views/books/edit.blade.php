@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ url('/all/books') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-primary-600 mb-6">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Back to All Books
    </a>

    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Book</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @include('books._form', [
            'action' => url('/books/' . $book->id),
            'method' => 'PUT',
            'buttonText' => 'Update Book',
            'book' => $book,
        ])
    </div>
</div>
@endsection
