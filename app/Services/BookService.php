<?php

namespace App\Services;

use App\Models\Book;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Collection;

class BookService
{
    public function list(): Collection
    {
        return Book::with(['authors', 'subjects'])->get();
    }

    public function create(array $data): Book
    {
        $book = Book::create($data);

        $book->authors()->sync($data['authors']);
        $book->subjects()->sync($data['subjects']);

        return $book->load(['authors', 'subjects']);
    }

    public function getById(int $id): Book
    {
        return Book::with(['authors', 'subjects'])->find($id) ?? throw new NotFoundException('Livro');
    }

    public function update(int $id, array $data): Book
    {
        $book = Book::find($id) ?? throw new NotFoundException('Livro');

        $book->update($data);
        $book->authors()->sync($data['authors']);
        $book->subjects()->sync($data['subjects']);

        return $book->load(['authors', 'subjects']);
    }

    public function delete(int $id): bool
    {
        $book = Book::find($id) ?? throw new NotFoundException('Livro');

        return $book->delete();
    }
}
