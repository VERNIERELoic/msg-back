<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\UserController;

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
        Route::get('timetable', 'getTimeTable');
        Route::post('registerschedule', 'registerSchedule');
        Route::post('addbooking', 'addBooking');
        Route::post('addunavailability', 'addUnavailability');
        Route::post('removeunavailability', 'removeUnavailability');
    });
});

Route::controller(UserController::class)->group(function () {
    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::get('getallusers', 'getAllUsers');
        Route::get('getuser/{id}', 'getUser');
        Route::delete('removeuser/{id}', 'removeUser');
        Route::put('addadmin', 'addAdmin');
        Route::put('removeadmin', 'removeAdmin');
    });
});
