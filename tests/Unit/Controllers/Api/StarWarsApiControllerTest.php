<?php

namespace Tests\Unit\Controllers\Api;

use App\Http\Controllers\Api\StarWarsApiController;
use App\Services\StarWars\StarWarsApiClient;
use Illuminate\Http\Request;
use Tests\TestCase;
use Mockery;

class StarWarsApiControllerTest extends TestCase
{
    private StarWarsApiController $controller;
    private $mockService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockService = Mockery::mock(StarWarsApiClient::class);
        $this->controller = new StarWarsApiController($this->mockService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_get_people_passes_all_query_params(): void
    {
        // Arrange
        $expectedResponse = [
            'message' => 'ok',
            'results' => [
                ['name' => 'Luke Skywalker']
            ]
        ];

        $queryParams = ['page' => 2, 'limit' => 10, 'search' => 'skywalker'];

        $this->mockService
            ->shouldReceive('getPeople')
            ->with($queryParams)
            ->once()
            ->andReturn($expectedResponse);

        $request = Request::create('/api/star-wars/people', 'GET', $queryParams);

        // Act
        $response = $this->controller->getPeople($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expectedResponse, $response->getData(true));
    }

    public function test_get_person_returns_person_details(): void
    {
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
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expectedResponse, $response->getData(true));
    }

    public function test_get_films_passes_query_params(): void
    {
        // Arrange
        $expectedResponse = [
            'message' => 'ok',
            'result' => [
                ['title' => 'A New Hope']
            ]
        ];

        $queryParams = ['title' => 'New Hope', 'director' => 'Lucas'];

        $this->mockService
            ->shouldReceive('getFilms')
            ->with($queryParams)
            ->once()
            ->andReturn($expectedResponse);

        $request = Request::create('/api/star-wars/films', 'GET', $queryParams);

        // Act
        $response = $this->controller->getFilms($request);

        // Assert
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expectedResponse, $response->getData(true));
    }

    public function test_get_film_returns_film_details(): void
    {
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
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expectedResponse, $response->getData(true));
    }
}
