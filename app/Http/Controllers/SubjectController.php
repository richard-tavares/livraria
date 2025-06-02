<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubjectRequest;
use App\Services\SubjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SubjectController extends Controller
{
    public function __construct(
        private readonly SubjectService $service
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    public function store(SubjectRequest $request): JsonResponse
    {
        $subject = $this->service->create($request->validated());
        return response()->json($subject, Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->getById($id));
    }

    public function update(SubjectRequest $request, int $id): JsonResponse
    {
        $subject = $this->service->update($id, $request->validated());
        return response()->json($subject);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
