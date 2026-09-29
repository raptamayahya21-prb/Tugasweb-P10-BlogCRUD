<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Redirect root ke posts index
Route::redirect('/', '/posts');

// Requirement 1: Route::resource('posts') + named routes
Route::resource('posts', PostController::class);
