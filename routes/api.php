<?php

use App\Http\Controllers\api\UsersController;
use App\Http\Middleware\CheckToken;
use Illuminate\Support\Facades\Route;

Route::post('/users/signup', [UsersController::class, 'SignUp']);
Route::post('/users/adduser', [UsersController::class, 'AddUser']);
Route::resource('users', UsersController::class);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/users/signin', [UsersController::class, 'SignIn']);
    Route::post('/users/logout', [UsersController::class, 'LogOut']);
});
