<?php

namespace App\Repositories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function all(): Collection
    {
        return Author::all();
    }

    public function find(int $id): ?Author
    {
        return Author::find($id);
    }

    public function create(array $data): Author
    {
        return Author::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $author = $this->find($id);
        return $author ? $author->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $author = $this->find($id);
        return $author ? $author->delete() : false;
    }
}
