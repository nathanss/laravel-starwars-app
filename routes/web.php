<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\StarWarsController;

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');

Route::get('/person/{id}', [StarWarsController::class, 'showPerson'])->name('person.show');
Route::get('/movie/{id}', [StarWarsController::class, 'showFilm'])->name('movie.show');
