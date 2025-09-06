<?php

use App\Http\Controllers\Api\StarWarsController;
use App\Services\StarWarsApiService;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->mockService = mock(StarWarsApiService::class);
    $this->controller = new StarWarsController($this->mockService);
});

test('controller can get people with query parameters', function () {
    // Arrange
    $expectedResponse = [
        'message' => 'ok',
        'results' => [
            ['name' => 'Luke Skywalker']
        ]
    ];

    $queryParams = [
        'page' => 2,
        'limit' => 10,
        'search' => 'skywalker'
    ];

    $this->mockService
        ->shouldReceive('getPeople')
        ->with($queryParams)
        ->once()
        ->andReturn($expectedResponse);

    $request = Request::create('/api/star-wars/people', 'GET', $queryParams);

    // Act
    $response = $this->controller->getPeople($request);

    // Assert
    expect($response->getStatusCode())->toBe(200)
        ->and($response->getData(true))->toBe($expectedResponse);
});

test('controller can get person details', function () {
    // Arrange
    $expectedResponse = [
        'message' => 'ok',
        'result' => [
            'properties' => ['name' => 'Luke Skywalker']
        ]
    ];

    $this->mockService
        ->shouldReceive('getPerson')
        ->with('1')
        ->once()
        ->andReturn($expectedResponse);

    // Act
    $response = $this->controller->getPerson('1');

    // Assert
    expect($response->getStatusCode())->toBe(200)
        ->and($response->getData(true))->toBe($expectedResponse);
});

test('controller can get films list with query parameters', function () {
    // Arrange
    $expectedResponse = [
        'message' => 'ok',
        'result' => [
            ['title' => 'A New Hope']
        ]
    ];

    $queryParams = [
        'title' => 'New Hope',
        'director' => 'Lucas'
    ];

    $this->mockService
        ->shouldReceive('getFilms')
        ->with($queryParams)
        ->once()
        ->andReturn($expectedResponse);

    $request = Request::create('/api/star-wars/films', 'GET', $queryParams);

    // Act
    $response = $this->controller->getFilms($request);

    // Assert
    expect($response->getStatusCode())->toBe(200)
        ->and($response->getData(true))->toBe($expectedResponse);
});

test('controller can get film details', function () {
    // Arrange
    $expectedResponse = [
        'message' => 'ok',
        'result' => [
            'properties' => ['title' => 'A New Hope']
        ]
    ];

    $this->mockService
        ->shouldReceive('getFilm')
        ->with('1')
        ->once()
        ->andReturn($expectedResponse);

    // Act
    $response = $this->controller->getFilm('1');

    // Assert
    expect($response->getStatusCode())->toBe(200)
        ->and($response->getData(true))->toBe($expectedResponse);
});
