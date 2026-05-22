@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Edit Book</h1>

            @include('books._form', [
                'action' => url('/books/' . $book->id),
                'method' => 'PUT',
                'buttonText' => 'Update Book',
                'book' => $book,
            ])
        </div>
    </div>
@endsection