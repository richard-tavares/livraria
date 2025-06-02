<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $service
    ) {}

    public function index(Request $request): View
    {
        $filters = $this->service->getFilters();
        return view('dashboard', compact('filters'));
    }

    public function data(Request $request): JsonResponse
    {
        $books = $this->service->getFilteredBooks($request);
        $filters = $this->service->getFilters();

        return response()->json([
            'filters' => $filters,
            'books' => $books
        ]);
    }

    public function booksByAuthor(Request $request): JsonResponse
    {
        return response()->json($this->service->getBooksByAuthor($request));
    }

    public function booksByPublisher(Request $request): JsonResponse
    {
        return response()->json($this->service->getBooksByPublisher($request));
    }

    public function booksByYear(Request $request): JsonResponse
    {
        return response()->json($this->service->getBooksByYear($request));
    }

    public function booksByPrice(Request $request): JsonResponse
    {
        return response()->json($this->service->getBooksByPrice($request));
    }

    public function booksBySubject(Request $request): JsonResponse
    {
        return response()->json($this->service->getBooksBySubject($request));
    }
}
