<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/users', function () {
//     return response()->json(['message' => 'API работает']);
// });
Route::apiResource('users', UserController::class)->except(['create', 'store', 'destroy', 'update']);