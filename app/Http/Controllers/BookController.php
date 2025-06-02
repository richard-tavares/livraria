<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BookController extends Controller
{
    public function __construct(
        private readonly BookService $service
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    public function store(BookRequest $request): JsonResponse
    {
        $book = $this->service->create($request->validated());
        return response()->json($book, Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->getById($id));
    }

    public function update(BookRequest $request, int $id): JsonResponse
    {
        $book = $this->service->update($id, $request->validated());
        return response()->json($book);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
