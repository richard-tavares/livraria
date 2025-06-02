<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    private function applyFilters($query, Request $request): Builder
    {
        $filters = [
            'authors' => 'author',
            'subjects' => 'subject',
            'publishers' => 'publisher',
            'years' => 'publication_year',
        ];

        foreach ($filters as $param => $column) {
            if ($request->filled($param)) {
                $query->whereIn($column, explode(',', $request->$param));
            }
        }

        return $query;
    }

    public function getFilters(): array
    {
        $fields = ['author', 'subject', 'publisher', 'publication_year'];

        $filters = [];
        foreach ($fields as $field) {
            $filters[$field === 'publication_year' ? 'years' : $field . 's'] =
                DB::table('view_books_report')->select($field)->distinct()->pluck($field);
        }

        return $filters;
    }

    public function getFilteredBooks(Request $request): Collection
    {
        $query = DB::table('view_books_report');
        return $this->applyFilters($query, $request)->get();
    }

    public function getBooksByAuthor(?Request $request = null): array
    {
        $query = DB::table('view_books_report')
            ->select('author', DB::raw('COUNT(DISTINCT title) as total'))
            ->groupBy('author')
            ->orderByDesc('total');

        if ($request !== null) {
            $this->applyFilters($query, $request);
        }

        return $query->get()->toArray();
    }

    public function getBooksByPublisher(?Request $request = null): array
    {
        $query = DB::table('view_books_report')
            ->select('publisher', DB::raw('COUNT(DISTINCT title) as total'))
            ->groupBy('publisher')
            ->orderByDesc('total');

        if ($request !== null) {
            $this->applyFilters($query, $request);
        }

        return $query->get()->toArray();
    }

    public function getBooksByYear(?Request $request = null): array
    {
        $query = DB::table('view_books_report')
            ->select('publication_year', DB::raw('COUNT(DISTINCT title) as total'))
            ->groupBy('publication_year')
            ->orderBy('publication_year');

        if ($request !== null) {
            $this->applyFilters($query, $request);
        }

        return $query->get()->toArray();
    }

    public function getBooksByPrice(?Request $request = null): array
    {
        $query = DB::table('view_books_report')
            ->select('title', DB::raw('MAX(price) as price'))
            ->groupBy('title')
            ->orderByDesc('price');

        if ($request !== null) {
            $this->applyFilters($query, $request);
        }

        return $query->get()->toArray();
    }

    public function getBooksBySubject(?Request $request = null): array
    {
        $query = DB::table('view_books_report')
            ->select('subject', DB::raw('COUNT(DISTINCT title) as total'))
            ->groupBy('subject')
            ->orderByDesc('total');

        if ($request !== null) {
            $this->applyFilters($query, $request);
        }

        return $query->get()->toArray();
    }
}
