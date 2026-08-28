<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// --- RUTE PUBLIK (SINGLE PAGE DISPLAY) ---
Route::get('/', [PublicController::class, 'index'])->name('public.display');

// --- REDIRECT DASHBOARD DEFAULT BREEZE ---
Route::get('/dashboard', function () {
    return redirect()->route('admin.currencies.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- RUTE ADMIN ---
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/currencies', [AdminController::class, 'currencies'])->name('admin.currencies.index');
    Route::post('/currencies', [AdminController::class, 'storeCurrency'])->name('admin.currencies.store');
    Route::put('/currencies/update-all', [AdminController::class, 'updateAllCurrencies'])->name('admin.currencies.updateAll');
    Route::delete('/currencies/{currency}', [AdminController::class, 'destroyCurrency'])->name('admin.currencies.destroy');

    Route::get('/company', [AdminController::class, 'editCompany'])->name('admin.company.edit');
    // Diubah menjadi POST untuk kestabilan submit form
    Route::post('/company', [AdminController::class, 'updateCompany'])->name('admin.company.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';