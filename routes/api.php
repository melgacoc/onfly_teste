<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'message' => 'User data fetched successfully',
    ], 200);
});

//Route::get('/user', function (Request $request) {
    //return $request->user();
//})->middleware('auth:sanctum');