<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;

// HomeController
Route::get('/', [HomeController::class, 'landing'])->middleware('onlyGuest');

Route::get('/register', [HomeController::class, 'register'])->middleware('onlyGuest');
Route::post('/register', [HomeController::class, 'register_save'])->middleware('onlyGuest');

Route::get('/login', [HomeController::class, 'login'])->middleware('onlyGuest');
Route::post('/login', [HomeController::class, 'login_save'])->middleware('onlyGuest');

Route::get('/logout', [HomeController::class, 'logout']);


// FeedController
Route::get('/feedx', [FeedController::class, 'feed']);
Route::post('/add', [FeedController::class, 'add_post']);
Route::get('/add', [FeedController::class, 'add']);
Route::post('/add_save', [FeedController::class, 'add_save']);

Route::post('/likes', [FeedController::class, 'likes']);
Route::post('/dislike', [FeedController::class, 'dislike']);

Route::post('/saved', [FeedController::class, 'saved']);
Route::post('/unsaved', [FeedController::class, 'unsaved']);


// ProfilController
Route::get('/post_detail/{uuid_post}', [ProfilController::class, 'post_detail']);