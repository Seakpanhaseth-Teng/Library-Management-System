<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LibraryBook;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        LibraryBook::create([
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            'genre' => 'Fiction',
            'isbn' => '978-0-06-112008-4',
            'publication_year' => 1960,
            'publisher' => 'J.B. Lippincott & Co.',
            'pages' => 281,
            'shelf_location' => 'A1',
            'available_copies' => 3,
            'is_available' => true,
        ]);

        LibraryBook::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'genre' => 'Fiction',
            'isbn' => '978-0-452-28423-4',
            'publication_year' => 1949,
            'publisher' => 'Secker & Warburg',
            'pages' => 328,
            'shelf_location' => 'A2',
            'available_copies' => 2,
            'is_available' => true,
        ]);

        LibraryBook::create([
            'title' => 'A Brief History of Time',
            'author' => 'Stephen Hawking',
            'genre' => 'Non-Fiction',
            'isbn' => '978-0-553-38016-3',
            'publication_year' => 1988,
            'publisher' => 'Bantam Books',
            'pages' => 256,
            'shelf_location' => 'B1',
            'available_copies' => 1,
            'is_available' => true,
        ]);

        LibraryBook::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'genre' => 'Fiction',
            'isbn' => '978-0-7432-7356-5',
            'publication_year' => 1925,
            'publisher' => 'Charles Scribner\'s Sons',
            'pages' => 180,
            'shelf_location' => 'A3',
            'available_copies' => 0,
            'is_available' => false,
        ]);

        LibraryBook::create([
            'title' => 'Sapiens: A Brief History of Humankind',
            'author' => 'Yuval Noah Harari',
            'genre' => 'Non-Fiction',
            'isbn' => '978-0-06-231611-0',
            'publication_year' => 2011,
            'publisher' => 'Harper',
            'pages' => 443,
            'shelf_location' => 'B2',
            'available_copies' => 4,
            'is_available' => true,
        ]);
    }
}
