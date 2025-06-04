<?php

namespace App\Repositories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface
{
    public function all(): Collection;
    public function findWithRelations(int $id): ?Book;
    public function create(array $data): Book;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
