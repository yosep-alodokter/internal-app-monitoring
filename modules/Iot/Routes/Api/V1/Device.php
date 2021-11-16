<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'iots','as' => 'iot.'], function() {
    //datatable
    Route::group(['prefix' => 'devices','as' => 'device.'], function() {
        Route::group(['prefix' => 'histories','as' => 'history.'], function() {
            Route::get('input', function (Request $request) {
                return app('module.iot.action.api.v1.device.history.input')->handle($request);
            })->name('input');
        });
    });

});