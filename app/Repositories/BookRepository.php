<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookRepository implements BookRepositoryInterface
{
    public function all(): Collection
    {
        return Book::with(['authors', 'subjects'])->get();
    }

    public function findWithRelations(int $id): ?Book
    {
        return Book::with(['authors', 'subjects'])->find($id);
    }

    public function create(array $data): Book
    {
        $book = Book::create($data);
        $book->authors()->sync($data['authors'] ?? []);
        $book->subjects()->sync($data['subjects'] ?? []);
        return $book->load(['authors', 'subjects']);
    }

    public function update(int $id, array $data): bool
    {
        $book = Book::find($id);
        if (!$book) {
            return false;
        }

        $book->update($data);
        $book->authors()->sync($data['authors'] ?? []);
        $book->subjects()->sync($data['subjects'] ?? []);
        return true;
    }

    public function delete(int $id): bool
    {
        $book = Book::find($id);
        return $book ? $book->delete() : false;
    }
}
