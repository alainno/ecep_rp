<?php

Route::get('/', 'Auth\AuthController@getLogin');
Route::controller('/auth', 'Auth\AuthController');
Route::controller('/end-point', 'Auth\EndpointController');
Route::group([
    'middleware' => 'auth',
    'prefix' => '/admin',
], function () {
    Route::controller('/', 'DashboardController');
});
