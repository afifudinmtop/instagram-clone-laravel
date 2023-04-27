<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SearchController;

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
Route::get('/list_like/{uuid_post}', [PostController::class, 'list_like']);

Route::post('/saved', [PostController::class, 'saved']);
Route::post('/unsaved', [PostController::class, 'unsaved']);

Route::get('/delete/{uuid_post}', [PostController::class, 'delete']);
Route::get('/edit/{uuid_post}', [PostController::class, 'edit']);
Route::post('/edit/', [PostController::class, 'edit_save']);


Route::get('/comment/{uuid_post}', [PostController::class, 'list_comment']);
Route::post('/comment/', [PostController::class, 'comment_save']);
Route::get('/delete_comment/{uuid_comment}', [PostController::class, 'delete_comment']);

// SearchController
Route::get('/search_feed/', [SearchController::class, 'search_feed']);
Route::get('/searchx/', [SearchController::class, 'search']);
Route::post('/search_post/', [SearchController::class, 'search_post']);

// ProfilController
Route::get('/profile/', [ProfilController::class, 'profile']);
Route::get('/setting/', [ProfilController::class, 'setting']);
Route::post('/save_setting/', [ProfilController::class, 'save_setting']);