<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class StarWarsApiService
{
    protected string $baseUrl = 'https://www.swapi.tech/api';

    public function getPeople(array $params = []): array
    {
        $params = array_merge(['page' => 1], $params);
        $response = Http::get("{$this->baseUrl}/people", $params);
        return $this->handleResponse($response);
    }

    public function getPerson(string $id): array
    {
        $response = Http::get("{$this->baseUrl}/people/{$id}");
        return $this->handleResponse($response);
    }

    public function getFilms(array $params = []): array
    {
        $response = Http::get("{$this->baseUrl}/films", $params);
        return $this->handleResponse($response);
    }

    public function getFilm(string $id): array
    {
        $response = Http::get("{$this->baseUrl}/films/{$id}");
        return $this->handleResponse($response);
    }

    protected function handleResponse(Response $response): array
    {
        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => 'Failed to fetch data from Star Wars API',
            'status' => $response->status()
        ];
    }
}
