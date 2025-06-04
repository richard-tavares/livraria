<?php

namespace App\Services;

use App\Models\Book;
use App\Repositories\BookRepositoryInterface;
use App\Exceptions\NotFoundException;
use Illuminate\Database\Eloquent\Collection;

class BookService
{
    public function __construct(
        protected BookRepositoryInterface $repository
    ) {}

    public function list(): Collection
    {
        return $this->repository->all();
    }

    public function create(array $data): Book
    {
        return $this->repository->create($data);
    }

    public function getById(int $id): Book
    {
        return $this->repository->findWithRelations($id) ?? throw new NotFoundException('Livro');
    }

    public function update(int $id, array $data): Book
    {
        if (!$this->repository->update($id, $data)) {
            throw new NotFoundException('Livro');
        }

        return $this->getById($id);
    }

    public function delete(int $id): bool
    {
        if (!$this->repository->delete($id)) {
            throw new NotFoundException('Livro');
        }

        return true;
    }
}
