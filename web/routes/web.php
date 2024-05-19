<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackResponseController;
use App\Http\Controllers\GenerateController;
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
Route::post('/form', [FeedbackResponseController::class, 'handleForm'])->middleware(['auth', 'verified'])->name('form');
Route::get('/success', [FeedbackResponseController::class, 'success'])->middleware(['auth', 'verified'])->name('success');

Route::get('/generate', [GenerateController::class, 'view'])->middleware(['auth', 'verified'])->name('generate');
Route::post('/generate', [GenerateController::class, 'store'])->middleware(['auth', 'verified'])->name('generatePost');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
