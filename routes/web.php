<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

Route::get('/', [ImageController::class, 'create']);
Route::post('/', [ImageController::class, 'store']);
Route::get('/{image}', [ImageController::class, 'show']);
