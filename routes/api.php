<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;

Route::prefix('v1')->group(function () {
    Route::apiResource('authors', AuthorController::class);
    Route::apiResource('subjects', SubjectController::class);
    Route::apiResource('books', BookController::class);
    Route::get('/data', [DashboardController::class, 'data'])->name('data');
    Route::get('/books-by-author', [DashboardController::class, 'booksByAuthor'])->name('booksByAuthor');
    Route::get('/books-by-publisher', [DashboardController::class, 'booksByPublisher'])->name('booksByPublisher');
    Route::get('/books-by-year', [DashboardController::class, 'booksByYear'])->name('booksByYear');
    Route::get('/books-by-price', [DashboardController::class, 'booksByPrice']);
    Route::get('/books-by-subject', [DashboardController::class, 'booksBySubject']);
});
