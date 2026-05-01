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

Route::get('tasks/create',[TaskController::class,'create'])
    ->middleware(['auth','verified'])
    ->name('tasks.create');


require __DIR__.'/auth.php';
