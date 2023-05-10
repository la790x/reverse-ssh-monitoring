<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ActionApiPrivateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // rssh connection

        $this->app->bind(
            'app.action.api.private.rssh-connection.terminate',
            \App\Actions\Api\Private\RsshConnection\Terminate\Handler::class
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
