<?php

namespace App\Providers;

use App\Contracts\Repositories\ProductoRepositoryInterface;
use App\Repositories\ProductoRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->bind(
            ProductoRepositoryInterface::class,
            ProductoRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
