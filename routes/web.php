<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::get('/', function () {
//     return view('layouts.frontend');
// });

Volt::route('/', 'frontend.home')->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', App\Livewire\Profile\Index::class)->name('profile.edit');
});

require __DIR__ . '/auth.php';

//Route Hooks - Do not delete//
	Route::get('products', App\Livewire\Products\Index::class)->name('products.index')->middleware('auth');
	Route::get('categories', App\Livewire\Categories\Index::class)->name('categories.index')->middleware('auth');
