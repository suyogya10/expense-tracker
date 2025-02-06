<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExpenseController;

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/dashboard', [ExpenseController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::post('/user/update-earnings', [ProfileController::class, 'updateEarnings'])->name('user.updateEarnings');
    Route::get('/', [ExpenseController::class, 'index'])->name('index');

});

require __DIR__.'/auth.php';
