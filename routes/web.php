<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->name('welcome');


Route::get('dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth','verified'])->name('dashboard');

Route::resource('tasks', TaskController::class)
->middleware(['auth','verified']);

require __DIR__.'/auth.php';
