<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->name('welcome');


// Added throttle:web (20 req/min) to all authenticated routes
Route::get('dashboard', [TaskController::class, 'index'])
    ->middleware(['auth','verified','throttle:web'])
    ->name('dashboard');

Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])
    ->middleware(['auth','verified','throttle:web'])->name('tasks.complete');

Route::resource('tasks', TaskController::class)
->middleware(['auth','verified','throttle:web']);

require __DIR__.'/auth.php';
