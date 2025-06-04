<?php

namespace App\Services;

use App\Models\Author;
use App\Repositories\AuthorRepositoryInterface;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;

class AuthorService
{
    public function __construct(
        protected AuthorRepositoryInterface $repository
    ) {}

    public function list(): Collection
    {
        return $this->repository->all();
    }

    public function create(array $data): Author
    {
        return $this->repository->create($data);
    }

    public function getById(int $id): Author
    {
        return $this->repository->find($id) ?? throw new NotFoundException('Autor');
    }

    public function update(int $id, array $data): Author
    {
        if (!$this->repository->update($id, $data)) {
            throw new NotFoundException('Autor');
        }

        return $this->getById($id);
    }

    public function delete(int $id): bool
    {
        if (!$this->repository->delete($id)) {
            throw new NotFoundException('Autor');
        }

        return true;
    }
}
