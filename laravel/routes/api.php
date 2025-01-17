<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)->group(function(){
    //Route::post('register', 'register');
    //Route::get('/user/{user}', 'show');
    Route::get('user/{user}/address', 'show_address')->middleware('auth:api');
    Route::post('user/event/book', 'bookEvent')->middleware('auth:api');;
    Route::get('user/{user}/events', 'listEvents')->middleware('auth:api');
});

Route::controller(AddressController::class)->group(function() {
    Route::post('address', 'store')->middleware('auth:api');
    Route::get('address/{address}', 'show')->middleware('auth:api');
    Route::get('address/{address}/user', 'show_user')->middleware('auth:api');
});

//EventsController routing
Route::controller(EventController::class)->group(function() {
    Route::post('events', 'store')->middleware('auth:api');
    Route::get('events/{event}/users', 'listUsers')->middleware('auth:api');
    Route::get('events', 'index');
    Route::get('events/{event}', 'show');
});

Route::controller(EventTypeController::class)->group(function() {
    Route::get('types', 'listTypes');
    Route::post('type', 'store');
});
Route::controller(AuthController::class)->prefix('auth')->group(function() {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:api');
    Route::post('refresh', 'refresh')->middleware('auth:api');
    Route::get('me', 'me')->middleware('auth:api');
});


