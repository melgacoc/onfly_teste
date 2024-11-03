<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpensesController;

Route::get('/user', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'message' => 'User data fetched successfully',
    ], 200);
});

Route::post('/newUser', [App\Http\Controllers\UserController::class, 'store']);
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function (){
    Route::post('newExpanse', [ExpensesController::class, 'store']);
});
//Route::post('/newExpanse', [App\Http\Controllers\ExpansesController::class, 'store']);

//Route::get('/user', function (Request $request) {
    //return $request->user();
//})->middleware('auth:sanctum');