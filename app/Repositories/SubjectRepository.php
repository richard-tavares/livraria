<?php

namespace App\Repositories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function all(): Collection
    {
        return Subject::all();
    }

    public function find(int $id): ?Subject
    {
        return Subject::find($id);
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $subject = $this->find($id);
        return $subject ? $subject->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $subject = $this->find($id);
        return $subject ? $subject->delete() : false;
    }
}
