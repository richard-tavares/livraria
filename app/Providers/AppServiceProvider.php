<?php

namespace App\Providers;

use App\Repositories\AuthorRepository;
use App\Repositories\AuthorRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\BookRepositoryInterface;
use App\Repositories\BookRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\SubjectRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AuthorRepositoryInterface::class,
            AuthorRepository::class,
            BookRepositoryInterface::class,
            BookRepository::class,
            SubjectRepositoryInterface::class,
            SubjectRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
