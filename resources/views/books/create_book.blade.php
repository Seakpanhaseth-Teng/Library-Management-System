@extends('layouts.app')

@section('title', 'Add a New Book')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Add a New Book</h1>

            @include('books._form', [
                'action' => url('books/add'),
                'method' => 'POST',
                'buttonText' => 'Submit',
                'book' => null,
            ])
        </div>
    </div>
@endsection