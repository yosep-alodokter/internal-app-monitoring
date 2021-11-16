<?php

namespace Modules\Iot\Providers;

use Illuminate\Support\ServiceProvider;

class ActionApiV1IotDeviceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // datatable
        $this->app->bind(
            'module.iot.action.api.v1.device.history.input',
            \Modules\Iot\Actions\Api\V1\Device\History\Input\Handler::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
