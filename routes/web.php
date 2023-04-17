<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// HomeController
Route::get('/', [HomeController::class, 'landing']);

Route::get('/register', [HomeController::class, 'register']);
Route::post('/register', [HomeController::class, 'register_save']);

Route::get('/login', [HomeController::class, 'login']);
Route::post('/login', [HomeController::class, 'login_save']);