<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    public function __construct(
        private readonly AuthorService $service
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    public function store(AuthorRequest $request): JsonResponse
    {
        $author = $this->service->create($request->validated());
        return response()->json($author, Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->getById($id));
    }

    public function update(AuthorRequest $request, int $id): JsonResponse
    {
        $author = $this->service->update($id, $request->validated());
        return response()->json($author);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
