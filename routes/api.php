<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BlogController;

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group( ['middleware' => ["auth:sanctum"]], function(){
    //rutas
    Route::controller(UserController::class)->group(function () {
        Route::get('user-profile', 'userProfile');
        Route::post('logout',  'logout');
    });

    Route::controller(BlogController::class)->group(function () {
        Route::post('create-blog',  'create');
        Route::get('list-blog',  'list');
        Route::get('show-blog/{id}',  'show');
        Route::put('update-blog/{id}', 'update');
        Route::delete('delete-blog/{id}',  'delete');
    });
});

