<?php

namespace App\Providers;

use App\Actions\AuthUserAction;
use App\Actions\Contracts\AuthUserActionInterface;
use App\Actions\Contracts\CreateApplicantActionInterface;
use App\Actions\Contracts\GetApplicantActionInterface;
use App\Actions\CreateApplicantAction;
use App\Actions\GetApplicantAction;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    private array $providers = [
        AuthUserActionInterface::class => AuthUserAction::class,
        CreateApplicantActionInterface::class => CreateApplicantAction::class,
        GetApplicantActionInterface::class => GetApplicantAction::class
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
