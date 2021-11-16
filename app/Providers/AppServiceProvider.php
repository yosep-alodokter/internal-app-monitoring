<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Response::macro('api', function ($header = [], $data = [], $httpCode = 200) {
            return response()->json([
                'header' => $header,
                'data' => $data
            ], $httpCode);
        });

        // helper
        $this->app->bind(
            'string.helper',
            \App\Helpers\StringHelper::class
        );

        $this->app->bind(
            'file.helper',
            \App\Helpers\FileHelper::class
        );
        $this->app->bind(
            'config.helper',
            \App\Helpers\ConfigurationHelper::class
        );

        $this->app->bind(
            'ga.inventory.helper',
            \App\Helpers\GeneralAffair\InventoryHelper::class
        );

        $this->app->bind(
            'ga.persuratan.helper',
            \App\Helpers\GeneralAffair\PersuratanHelper::class
        );

        $this->app->bind(
            'hrd.employee.helper',
            \App\Helpers\Hrd\EmployeeHelper::class
        );

        $this->app->bind(
            'user.helper',
            \App\Helpers\UserHelper::class
        );

        $this->app->bind(
            'notification.helper',
            \App\Helpers\NotificationHelper::class
        );

        $this->app->bind(
            'iot.device.helper',
            \App\Helpers\Iot\DeviceHelper::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
