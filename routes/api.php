<?php

use App\Http\Controllers\Api\MetricsController;
use App\Http\Controllers\Api\StarWarsApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('star-wars')->group(function () {
    Route::get('/people', [StarWarsApiController::class, 'getPeople']);
    Route::get('/films', [StarWarsApiController::class, 'getFilms']);
    Route::get('/people/{id}', [StarWarsApiController::class, 'getPerson']);
    Route::get('/films/{id}', [StarWarsApiController::class, 'getFilm']);
});

Route::get('/metrics', [MetricsController::class, 'index']);
