<?php

namespace App\Providers;

use App\Repositories\ForgetPasswordRepository;
use App\Repositories\Interfaces\ForgetPasswordInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\Interfaces\TrashRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\TrashRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class,PostRepository::class);
        $this->app->bind(TrashRepositoryInterface::class,TrashRepository::class);
        $this->app->bind(ForgetPasswordInterface::class,ForgetPasswordRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}
