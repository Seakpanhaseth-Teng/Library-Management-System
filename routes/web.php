<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\LibraryController;

// http://127.0.1:8000/all/books
Route::get('/all/books', [LibraryController::class, 'allBooks']);

// http://127.0.1:8000/books/available
Route::get('/books/available', [LibraryController::class, 'availableBooks']);

// http://127.0.0.1:8000/books/fiction
Route::get('/books/fiction', [LibraryController::class, 'fictionBooks']);

// http://127.0.01:8000/books/nonfiction
Route::get('/books/nonfiction', [LibraryController::class, 'nonFictionBooks']);

//Route to display the form for adding a book
//Route::get('/books/add', function () {
//    return view('books.add');
//});

// http://127.0.01:8000/books/add
Route::post('/books/add', [LibraryController::class, 'addBook']);

http://127.0.0.1:8000/createbook
Route::get('/createbook', function () {
    return view('books.createbook');
});