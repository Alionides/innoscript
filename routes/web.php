<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/search', [ArticleController::class, 'search']);
});

