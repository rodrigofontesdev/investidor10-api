<?php

use App\Http\Controllers\V1\FetchNewsByCategory;
use App\Http\Controllers\V1\FetchNewsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::get('/news', FetchNewsController::class);
    Route::get('/categories/{category}', FetchNewsByCategory::class);
});
