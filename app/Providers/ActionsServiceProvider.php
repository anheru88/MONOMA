<?php

namespace App\Providers;

use App\Actions\AuthUserAction;
use App\Actions\Contracts\AuthUserActionInterface;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    private array $providers = [
        AuthUserActionInterface::class => AuthUserAction::class,
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
