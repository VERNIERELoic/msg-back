<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanningController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');

    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::get('logout', 'logout');
        Route::get('current', 'current');
        Route::post('refresh', 'refresh');
    });
});


Route::controller(PlanningController::class)->group(function () {
    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::post('addbooking', 'add_booking');
        Route::post('deletebooke', 'delete_booking');
        Route::get('getbooking', 'get_booking');
    });
});
