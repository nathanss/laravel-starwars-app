<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Services\StarWarsApiService;

Route::get('/', function () {
    return Inertia::render('home');
})->name('home');

Route::get('/person/{id}', function ($id, StarWarsApiService $starWarsApi) {
    $person = $starWarsApi->getPerson($id);
    return Inertia::render('person', [
        'person' => $person['result']['properties'] ?? []
    ]);
})->name('person.show');

Route::get('/movie/{id}', function ($id, StarWarsApiService $starWarsApi) {
    $movie = $starWarsApi->getFilm($id);
    return Inertia::render('movie', [
        'movie' => $movie['result']['properties'] ?? []
    ]);
})->name('movie.show');
