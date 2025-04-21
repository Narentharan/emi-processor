<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanDetailsController;
use App\Http\Controllers\EmiProcessingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/loan-details', [LoanDetailsController::class, 'index'])->name('loan.details');
    Route::get('/emi-processing', [EmiProcessingController::class, 'index'])->name('emi.index');
    Route::post('/emi-processing', [EmiProcessingController::class, 'process'])->name('emi.process');
});

require __DIR__.'/auth.php';
