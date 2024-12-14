<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Models\Chirp;


Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
Route::get('/', function () {
    $chirps = Chirp::all();
    return view('welcome', ['chirps' => $chirps]);
});

Route::post('/chirps',[ChirpController::class,'store']);

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
});

require __DIR__.'/auth.php';
