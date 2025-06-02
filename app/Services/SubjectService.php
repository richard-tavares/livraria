<?php

namespace App\Services;

use App\Models\Subject;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Collection;

class SubjectService
{
    public function list(): Collection
    {
        return Subject::all();
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function getById(int $id): Subject
    {
        return Subject::find($id) ?? throw new NotFoundException('Assunto');
    }

    public function update(int $id, array $data): Subject
    {
        $subject = Subject::find($id) ?? throw new NotFoundException('Assunto');

        $subject->update($data);

        return $subject;
    }

    public function delete(int $id): bool
    {
        $subject = Subject::find($id) ?? throw new NotFoundException('Assunto');

        return $subject->delete();
    }
}
