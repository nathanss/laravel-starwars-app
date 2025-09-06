<?php

use App\Http\Controllers\Api\StarWarsController;
use Illuminate\Support\Facades\Route;

Route::prefix('star-wars')->group(function () {
    Route::get('/people', [StarWarsController::class, 'getPeople']);
    Route::get('/films', [StarWarsController::class, 'getFilms']);
    Route::get('/people/{id}', [StarWarsController::class, 'getPerson']);
    Route::get('/films/{id}', [StarWarsController::class, 'getFilm']);
});
