<?php

namespace App\Repositories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;

interface SubjectRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?Subject;
    public function create(array $data): Subject;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
