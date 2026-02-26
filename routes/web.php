<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::resource('users', UserController::class)->middleware('auth');
Route::resource('videos', VideoController::class)->middleware('auth');
Route::resource('statistics', StatisticController::class)->middleware('auth');

Auth::routes();
