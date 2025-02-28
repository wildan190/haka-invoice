<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interface\CustomerRepositoryInterface;
use App\Repositories\Interface\MobilRepositoryInterface;
use App\Repositories\Interface\RentalRepositoryInterface;
use App\Repositories\Interface\InvoiceRepositoryInterface;
use App\Repositories\Interface\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\MobilRepository;
use App\Repositories\RentalRepository;
// use App\Repository\UserRepository as RepositoryUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(MobilRepositoryInterface::class, MobilRepository::class);
        $this->app->bind(RentalRepositoryInterface::class, RentalRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
