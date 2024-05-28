<?php

use App\Http\Controllers\api\BudgetController;
use App\Http\Controllers\api\DemandeController;
use App\Http\Controllers\api\RubricController;
use App\Http\Controllers\api\UsersController;
use App\Http\Middleware\CheckToken;
use Illuminate\Support\Facades\Route;

Route::put('/users/update/{user}', [UsersController::class, 'updating']);
Route::post('/users/signup', [UsersController::class, 'SignUp']);
Route::post('/users/signin', [UsersController::class, 'SignIn']);
Route::post('/users/adduser', [UsersController::class, 'AddUser']);
Route::get('/users/stats', [UsersController::class, 'getUserCountByRole']);
Route::get('/users/count', [UsersController::class, 'getUserCount']);
Route::put('/demandes/status/{demande}', [DemandeController::class, 'updateDemande']);
Route::get('/demandes/stats', [DemandeController::class, 'getDemandeCount']);
Route::get('/demandes/stats/years', [DemandeController::class, 'getDemandePerYear']);

Route::resource('users', UsersController::class);
Route::resource('rubrics', RubricController::class);
Route::resource('budgets', BudgetController::class);
Route::resource('demandes', DemandeController::class);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/users/logout', [UsersController::class, 'LogOut']);
});
