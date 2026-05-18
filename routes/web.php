<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Pridėtas Auth fasado importas
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Session;

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'lt'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/', function () {
    return redirect()->route('owners.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {
    Route::resource('owners', OwnerController::class)->only(['index', 'show']);
    Route::resource('cars', CarController::class)->only(['index', 'show']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('owners', OwnerController::class)->except(['index', 'show']);
    Route::resource('cars', CarController::class)->except(['index', 'show']);
});
