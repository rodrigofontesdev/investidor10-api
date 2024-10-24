<?php

use App\Http\Controllers\V1\FetchNewsByCategoryController;
use App\Http\Controllers\V1\FetchNewsController;
use App\Http\Controllers\V1\FetchSingleNewsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('/news', FetchNewsController::class);
    Route::get('/news/{slug}', FetchSingleNewsController::class);
    Route::get('/categories/{category}', FetchNewsByCategoryController::class);
});
