<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\PembayaranRepositoryInterface;
use App\Repositories\PembayaranRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PembayaranRepositoryInterface::class, PembayaranRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
