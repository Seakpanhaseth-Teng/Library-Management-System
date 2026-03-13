<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// class LibraryController extends Controller
// {
//     public function bookrecords(){
//         return view('library.bookrecords');
//     }
// }

use App\Models\LibraryBook;

class LibraryController extends Controller
{
    public function allBooks() {
        $books = LibraryBook::all();
        return view('books.all_books', ['books' => $books]);
    }

    public function availableBooks() {
        $books = LibraryBook::all(); // Fetch all books without filtering
        return view('/books/available', ['books' => $books]);
    }

    public function fictionBooks() {
        $books = LibraryBook::where('genre', 'Fiction')->get();
        return view('books.fiction', ['books' => $books]);
    }   

    public function nonFictionBooks() {
        $books = LibraryBook::where('genre', 'Non-Fiction')->get();
        return view('books.nonfiction', ['books' => $books]);
    }

    public function addBook(Request $request) {
        $book = new LibraryBook();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->genre = $request->genre;
        $book->isbn = $request->isbn;
        $book->publication_year = $request->publication_year;
        $book->publisher = $request->publisher;
        $book->pages = $request->pages;
        $book->shelf_location = $request->shelf_location;
        $book->available_copies = $request->available_copies;
        $book->is_available = $request->is_available;
        $book->save();

        return redirect('/all/books');
    }
}

//form route 

//route for form to post to

//route go call controller function

//controller function insert data jol Database

//redirect to page jas