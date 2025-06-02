<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('DROP VIEW IF EXISTS view_books_report');

        DB::statement("
            CREATE VIEW view_books_report AS
            SELECT
                authors.name AS author,
                books.title,
                books.publisher,
                books.publication_year,
                books.edition,
                books.price,
                subjects.description AS subject
            FROM books
            JOIN author_book ON author_book.book_id = books.id
            JOIN authors ON authors.id = author_book.author_id
            JOIN book_subject ON book_subject.book_id = books.id
            JOIN subjects ON subjects.id = book_subject.subject_id
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS view_books_report');
    }
};
