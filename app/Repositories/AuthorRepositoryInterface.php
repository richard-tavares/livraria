<?php

namespace App\Repositories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

interface AuthorRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Author;
    public function create(array $data): Author;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
