<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookRepository
{
    public function all(): Collection
    {
        return Book::all();
    }

    public function find(int $id): ?Book
    {
        return Book::find($id);
    }

    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $book = $this->find($id);
        return $book ? $book->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $book = $this->find($id);
        return $book ? $book->delete() : false;
    }
}
