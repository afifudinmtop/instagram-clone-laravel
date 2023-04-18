<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
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



// PostController
Route::get('/post_detail/{uuid_post}', [PostController::class, 'post_detail']);

Route::post('/likes', [PostController::class, 'likes']);
Route::post('/dislike', [PostController::class, 'dislike']);

Route::post('/saved', [PostController::class, 'saved']);
Route::post('/unsaved', [PostController::class, 'unsaved']);

Route::get('/delete/{uuid_post}', [PostController::class, 'delete']);
Route::get('/edit/{uuid_post}', [PostController::class, 'edit']);
Route::post('/edit/', [PostController::class, 'edit_save']);

Route::get('/list_like/{uuid_post}', [PostController::class, 'list_like']);