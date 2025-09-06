<?php

namespace Tests\Unit\Services;

use App\Services\StarWarsApiService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class StarWarsApiServiceTest extends TestCase
{
    private StarWarsApiService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new StarWarsApiService();
    }

    public function test_get_people_returns_people_list(): void
    {
        // Arrange
        $mockResponse = [
            'message' => 'ok',
            'results' => [
                [
                    'uid' => '1',
                    'name' => 'Luke Skywalker',
                    'url' => 'https://www.swapi.tech/api/people/1'
                ]
            ]
        ];

        Http::fake([
            'swapi.tech/api/people?page=2&limit=10' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->service->getPeople(['page' => 2, 'limit' => 10]);

        // Assert
        $this->assertEquals($mockResponse, $result);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://www.swapi.tech/api/people?page=2&limit=10';
        });
    }

    public function test_get_people_uses_default_page(): void
    {
        // Arrange
        $mockResponse = [
            'message' => 'ok',
            'results' => []
        ];

        Http::fake([
            'swapi.tech/api/people?page=1' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->service->getPeople([]);

        // Assert
        $this->assertEquals($mockResponse, $result);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://www.swapi.tech/api/people?page=1';
        });
    }

    public function test_get_person_returns_person_details(): void
    {
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
        $this->assertEquals($mockResponse, $result);
    }

    public function test_get_films_returns_films_list(): void
    {
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
            'swapi.tech/api/films?title=New%20Hope' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->service->getFilms(['title' => 'New Hope']);

        // Assert
        $this->assertEquals($mockResponse, $result);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://www.swapi.tech/api/films?title=New%20Hope';
        });
    }

    public function test_get_films_with_no_params(): void
    {
        // Arrange
        $mockResponse = [
            'message' => 'ok',
            'result' => []
        ];

        Http::fake([
            'swapi.tech/api/films' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->service->getFilms([]);

        // Assert
        $this->assertEquals($mockResponse, $result);
        Http::assertSent(function ($request) {
            return $request->url() === 'https://www.swapi.tech/api/films';
        });
    }
    public function test_get_film_returns_film_details(): void
    {
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
        $this->assertEquals($mockResponse, $result);
    }

    public function test_handles_api_error_response(): void
    {
        // Arrange
        Http::fake([
            'swapi.tech/api/people/999' => Http::response(null, 404)
        ]);

        // Act
        $result = $this->service->getPerson('999');

        // Assert
        $this->assertArrayHasKey('error', $result);
        $this->assertEquals(404, $result['status']);
    }
}
