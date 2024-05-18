<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/live', [LiveController::class, 'display'])->middleware(['auth', 'verified'])->name('live');
Route::post('/form', [FormController::class, 'handleForm'])->middleware(['auth', 'verified'])->name('form');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
