<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.welcome');
})->name('welcome');


Route::get('dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth','verified'])->name('dashboard');


require __DIR__.'/auth.php';
