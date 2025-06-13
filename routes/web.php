<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/piscar', function () {
    return view('piscar');
});

Route::get('/vendas', function () {
    return view('vendas'); // vai buscar resources/views/vendas.blade.php
})->name('vendas');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
