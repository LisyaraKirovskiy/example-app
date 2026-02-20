<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('users', UserController::class)->middleware('auth');

// Route::prefix('users')->group(function () {
//     Route::get('', [HomeController::class, 'index'])->name('users.index');
//     Route::get('{id}', [HomeController::class, 'show'])->name('users.show');
//     Route::post('', [HomeController::class, 'store'])->name('users.store');
//     Route::delete('{id}', [HomeController::class, 'destroy'])->name('users.destroy');
//     Route::patch('{id}', [HomeController::class, 'update'])->name('users.update');
// });
Auth::routes();
