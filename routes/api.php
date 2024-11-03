<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpensesController;


Route::post('/newUser', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
Route::post('/login', [App\Http\Controllers\UserController::class, 'login'])->name('user.login');
Route::middleware('auth:sanctum')->group(function (){
    Route::apiResource('/expenses', ExpensesController::class);
});
