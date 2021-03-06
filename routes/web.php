<?php

use Modules\User\Facades\MufUser;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('monitoring.index'));
});

Route::get('/monitoring/other', 'MonitoringController@other')->name('devices.detail.one');
Route::get('/monitoring/device/detail/{id}', 'MonitoringController@detail')->name('devices.detail');
Route::get('/monitoring/device/detail-all/{id}', 'MonitoringController@detailAll')->name('devices.detail.all');
Route::resource('monitoring', 'MonitoringController');
