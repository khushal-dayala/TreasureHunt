<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;


Route::get('/', [GameController::class, 'index'])->name('home');
Route::post('/start', [GameController::class, 'startGame'])->name('start');
Route::post('/cell-click', [GameController::class, 'processClick'])->name('cell.click');
Route::get('/treasure-hunt/{random_number}', [GameController::class, 'showResult'])->name('result');
