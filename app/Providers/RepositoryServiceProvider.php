<?php

namespace App\Providers;

use App\Repositories\Contracts\ApplicantRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EloquentApplicantRepository;
use App\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private array $providers = [
        UserRepositoryInterface::class => EloquentUserRepository::class,
        ApplicantRepositoryInterface::class => EloquentApplicantRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->providers as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
