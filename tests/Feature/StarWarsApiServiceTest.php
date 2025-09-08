<?php

use App\Services\StarWarsApiService;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->service = new StarWarsApiService();
});


test('service can get person details', function () {
    // Arrange
    $mockResponse = [
        'message' => 'ok',
        'result' => [
            'properties' => [
                'height' => '172',
                'mass' => '77',
                'name' => 'Luke Skywalker'
            ]
        ]
    ];

    Http::fake([
        'swapi.tech/api/people/1' => Http::response($mockResponse, 200)
    ]);

    // Act
    $result = $this->service->getPerson('1');

    // Assert
    expect($result)->toBe($mockResponse);
});

test('service can get films list', function () {
    // Arrange
    $mockResponse = [
        'message' => 'ok',
        'result' => [
            [
                'uid' => '1',
                'properties' => [
                    'title' => 'A New Hope',
                    'episode_id' => 4
                ]
            ]
        ]
    ];

    Http::fake([
        'swapi.tech/api/films' => Http::response($mockResponse, 200)
    ]);

    // Act
    $result = $this->service->getFilms();

    // Assert
    expect($result)->toBe($mockResponse);
});

test('service can get film details', function () {
    // Arrange
    $mockResponse = [
        'message' => 'ok',
        'result' => [
            'properties' => [
                'title' => 'A New Hope',
                'episode_id' => 4,
                'director' => 'George Lucas'
            ]
        ]
    ];

    Http::fake([
        'swapi.tech/api/films/1' => Http::response($mockResponse, 200)
    ]);

    // Act
    $result = $this->service->getFilm('1');

    // Assert
    expect($result)->toBe($mockResponse);
});

test('service handles api error response', function () {
    // Arrange
    Http::fake([
        'swapi.tech/api/people/999' => Http::response(null, 404)
    ]);

    // Act
    $result = $this->service->getPerson('999');

    // Assert
    expect($result)
        ->toHaveKey('error')
        ->and($result['status'])->toBe(404);
});
