<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');

Route::get('/person/{id}', function ($id) {
    return Inertia::render('person', [
        'id' => $id
    ]);
})->name('person.show');

Route::get('/movie/{id}', function ($id) {
    return Inertia::render('movie', [
        'id' => $id
    ]);
})->name('movie.show');
