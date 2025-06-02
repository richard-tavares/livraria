<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'A Guerra dos Tronos',
                'publisher' => 'Suma',
                'publication_year' => 1996,
                'edition' => 1,
                'price' => 59.90,
                'authors' => ['George R.R. Martin'],
                'subjects' => ['Fantasia']
            ],
            [
                'title' => 'A Fúria dos Reis',
                'publisher' => 'Suma',
                'publication_year' => 1998,
                'edition' => 1,
                'price' => 62.90,
                'authors' => ['George R.R. Martin'],
                'subjects' => ['Fantasia']
            ],
            [
                'title' => 'O Senhor dos Anéis: A Sociedade do Anel',
                'publisher' => 'HarperCollins',
                'publication_year' => 1954,
                'edition' => 1,
                'price' => 89.90,
                'authors' => ['J.R.R. Tolkien'],
                'subjects' => ['Fantasia', 'Aventura']
            ],
            [
                'title' => 'Harry Potter e a Pedra Filosofal',
                'publisher' => 'Rocco',
                'publication_year' => 1997,
                'edition' => 1,
                'price' => 39.90,
                'authors' => ['J.K. Rowling'],
                'subjects' => ['Fantasia', 'Aventura']
            ],
            [
                'title' => 'Harry Potter e a Ordem da Fênix',
                'publisher' => 'Rocco',
                'publication_year' => 2003,
                'edition' => 1,
                'price' => 42.90,
                'authors' => ['J.K. Rowling'],
                'subjects' => ['Fantasia', 'Aventura']
            ],
            [
                'title' => 'Jogos Vorazes',
                'publisher' => 'Rocco',
                'publication_year' => 2008,
                'edition' => 1,
                'price' => 45.00,
                'authors' => ['Suzanne Collins'],
                'subjects' => ['Distopia', 'Ação']
            ],
            [
                'title' => 'Em Chamas',
                'publisher' => 'Rocco',
                'publication_year' => 2009,
                'edition' => 1,
                'price' => 47.00,
                'authors' => ['Suzanne Collins'],
                'subjects' => ['Distopia', 'Ação']
            ],
            [
                'title' => 'A Esperança',
                'publisher' => 'Rocco',
                'publication_year' => 2010,
                'edition' => 1,
                'price' => 50.99,
                'authors' => ['Suzanne Collins'],
                'subjects' => ['Distopia', 'Ação']
            ],
            [
                'title' => 'IT: A Coisa',
                'publisher' => 'Objetiva',
                'publication_year' => 2001,
                'edition' => 1,
                'price' => 111.90,
                'authors' => ['Stephen King'],
                'subjects' => ['Terror', 'Romance']
            ]
        ];

        foreach ($books as $data) {
            $book = Book::create([
                'title' => $data['title'],
                'publisher' => $data['publisher'],
                'publication_year' => $data['publication_year'],
                'edition' => $data['edition'],
                'price' => $data['price']
            ]);

            $authorIds = Author::whereIn('name', $data['authors'])->pluck('id');
            $subjectIds = Subject::whereIn('description', $data['subjects'])->pluck('id');

            $book->authors()->attach($authorIds);
            $book->subjects()->attach($subjectIds);
        }
    }
}
