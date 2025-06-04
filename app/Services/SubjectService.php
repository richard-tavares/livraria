<?php

namespace App\Services;

use App\Models\Subject;
use App\Repositories\SubjectRepositoryInterface;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;

class SubjectService
{
    public function __construct(
        protected SubjectRepositoryInterface $repository
    ) {}

    public function list(): Collection
    {
        return $this->repository->all();
    }

    public function create(array $data): Subject
    {
        return $this->repository->create($data);
    }

    public function getById(int $id): Subject
    {
        return $this->repository->find($id) ?? throw new NotFoundException('Assunto');
    }

    public function update(int $id, array $data): Subject
    {
        if (!$this->repository->update($id, $data)) {
            throw new NotFoundException('Assunto');
        }

        return $this->getById($id);
    }

    public function delete(int $id): bool
    {
        if (!$this->repository->delete($id)) {
            throw new NotFoundException('Assunto');
        }

        return true;
    }
}
