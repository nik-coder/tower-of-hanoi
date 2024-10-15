<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TowerOfHanoiController;

Route::get('/state', [TowerOfHanoiController::class, 'getState']);
Route::post('/move/{from}/{to}', [TowerOfHanoiController::class, 'move']);

