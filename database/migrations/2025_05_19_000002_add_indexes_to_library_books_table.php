<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('library_books', function (Blueprint $table) {
            $table->index('genre');
            $table->index('is_available');
            $table->index('author');
        });
    }

    public function down(): void
    {
        Schema::table('library_books', function (Blueprint $table) {
            $table->dropIndex(['genre']);
            $table->dropIndex(['is_available']);
            $table->dropIndex(['author']);
        });
    }
};
