<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::view('/authors', 'authors')->name('authors');
Route::view('/subjects', 'subjects')->name('subjects');
Route::view('/books', 'books')->name('books');
