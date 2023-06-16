<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('video', [VideoController::class, 'getVideo']);
Route::get('video-render', [VideoController::class, 'getVideoRender']);
