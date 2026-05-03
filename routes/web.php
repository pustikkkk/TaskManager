<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->name('welcome');


Route::get('dashboard', [TaskController::class, 'index'])
    ->middleware(['auth','verified'])
    ->name('dashboard');

Route::patch('tasks/{task}/complete', [TaskController::class, 'complete'])
    ->middleware(['auth','verified'])->name('tasks.complete');

Route::resource('tasks', TaskController::class)
->middleware(['auth','verified']);

require __DIR__.'/auth.php';
