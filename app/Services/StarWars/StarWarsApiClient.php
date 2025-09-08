<?php

namespace App\Services\StarWars;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;

class StarWarsApiClient
{
    protected string $baseUrl = 'https://www.swapi.tech/api';

    public function getPeople(array $params = []): array
    {
        $params = array_merge(['page' => 1], $params);
        return $this->get('people', $params);
    }

    public function getPerson(string $id): array
    {
        return $this->get("people/{$id}");
    }

    public function getFilms(array $params = []): array
    {
        return $this->get('films', $params);
    }

    public function getFilm(string $id): array
    {
        return $this->get("films/{$id}");
    }

    public function get(string $endpoint, array $params = []): array
    {
        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/{$endpoint}", $params);
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error("API request failed for {$endpoint}: " . $e->getMessage());
            throw $e;
        }
    }

    public function getFromUrl(string $url): array
    {
        try {
            $response = Http::timeout(5)->get($url);
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            Log::error("API request failed for {$url}: " . $e->getMessage());
            throw $e;
        }
    }

    protected function handleResponse(Response $response): array
    {
        if ($response->successful()) {
            return $response->json();
        }

        $error = "API request failed with status {$response->status()}";
        Log::error($error);

        return [
            'error' => $error,
            'status' => $response->status()
        ];
    }
}
