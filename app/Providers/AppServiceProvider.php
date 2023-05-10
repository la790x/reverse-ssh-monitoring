<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // response

        Response::macro('api', function ($status = true, $httpCode = 200, $data = [], $successMessage = '', $errorMessage = '', $actionClient = '') {
            return response()->json([
                'status' => $status,
                'http_code' => $httpCode,
                'data' => $data,
                'success_message' => $successMessage,
                'error_message' => $errorMessage,
                'action_client' => $actionClient,
            ], $httpCode);
        });

        // helper

        $this->app->bind(
            'string.helper',
            \App\Helpers\StringHelper::class
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
