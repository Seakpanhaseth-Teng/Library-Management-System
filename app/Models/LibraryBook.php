<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryBook extends Model
{
    protected $primaryKey = 'book_id'; // Only if your primary key is NOT "id"
    protected $table = 'library_books';
}
