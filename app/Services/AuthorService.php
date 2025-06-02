<?php

namespace App\Services;

use App\Models\Author;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Collection;

class AuthorService
{
    public function list(): Collection
    {
        return Author::all();
    }

    public function create(array $data): Author
    {
        return Author::create($data);
    }

    public function getById(int $id): Author
    {
        return Author::find($id) ?? throw new NotFoundException('Autor');
    }

    public function update(int $id, array $data): Author
    {
        $author = Author::find($id) ?? throw new NotFoundException('Autor');

        $author->update($data);

        return $author;
    }

    public function delete(int $id): bool
    {
        $author = Author::find($id) ?? throw new NotFoundException('Autor');

        return $author->delete();
    }
}
