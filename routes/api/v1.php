<?php

use App\Http\Controllers\V1\News;
use Illuminate\Support\Facades\Route;

Route::get('/news', News::class);
