@extends('layouts.app')

@section('title', 'Add a New Book')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Add a New Book</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        @include('books._form', [
            'action' => url('books/add'),
            'method' => 'POST',
            'buttonText' => 'Add Book',
            'book' => null,
        ])
    </div>
</div>
@endsection
