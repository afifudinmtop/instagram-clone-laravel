<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'landing']);
Route::get('/register', [HomeController::class, 'register']);