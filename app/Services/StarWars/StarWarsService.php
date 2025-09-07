<?php

namespace App\Services\StarWars;

use App\Services\StarWars\Dto\FilmDto;
use App\Services\StarWars\Dto\PersonDto;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StarWarsService
{
    public function __construct(
        protected StarWarsApiClient $apiClient
    ) {}

    public function getPersonWithFilms(string $id): array
    {
        $cacheKey = "person_{$id}_with_films";

        try {
            return Cache::remember($cacheKey, now()->addHours(24), function () use ($id) {
                $personData = $this->apiClient->get("people/{$id}");
                if (isset($personData['error'])) {
                    throw new \RuntimeException("Failed to fetch person: " . $personData['error']);
                }

                $person = PersonDto::fromArray($personData['result']['properties'] ?? []);
                $films = $this->getFilmsForPerson($person);

                return [
                    'person' => $person->toArray(),
                    'films' => $films
                ];
            });
        } catch (\Exception $e) {
            Log::error("Error fetching person {$id}: " . $e->getMessage());

            // Try to return stale data if available
            $staleData = Cache::get($cacheKey);
            if ($staleData) {
                Log::info("Serving stale data for person {$id}");
                return $staleData;
            }

            return [
                'person' => PersonDto::createError()->toArray(),
                'films' => [],
                'error' => 'Failed to load person data. Please try again later.'
            ];
        }
    }

    public function getFilmWithCharacters(string $id): array
    {
        $cacheKey = "film_{$id}_with_characters";

        try {
            return Cache::remember($cacheKey, now()->addHours(24), function () use ($id) {
                $filmData = $this->apiClient->get("films/{$id}");
                if (isset($filmData['error'])) {
                    throw new \RuntimeException("Failed to fetch film: " . $filmData['error']);
                }

                $film = FilmDto::fromArray($filmData['result']['properties'] ?? []);
                $characters = $this->getCharactersForFilm($film);

                return [
                    'movie' => $film->toArray(),
                    'characters' => $characters
                ];
            });
        } catch (\Exception $e) {
            Log::error("Error fetching film {$id}: " . $e->getMessage());

            // Try to return stale data if available
            $staleData = Cache::get($cacheKey);
            if ($staleData) {
                Log::info("Serving stale data for film {$id}");
                return $staleData;
            }

            return [
                'movie' => FilmDto::createError()->toArray(),
                'characters' => [],
                'error' => 'Failed to load film data. Please try again later.'
            ];
        }
    }

    protected function getFilmsForPerson(PersonDto $person): array
    {
        $films = [];
        foreach ($person->films as $filmUrl) {
            try {
                $filmData = $this->apiClient->getFromUrl($filmUrl);
                if (isset($filmData['result']['properties'])) {
                    $films[] = [
                        'title' => $filmData['result']['properties']['title'],
                        'uid' => $filmData['result']['uid'] ?? null,
                        'url' => $filmUrl
                    ];
                }
            } catch (\Exception $e) {
                Log::warning("Failed to fetch film from {$filmUrl}: " . $e->getMessage());
                continue;
            }
        }
        return $films;
    }

    protected function getCharactersForFilm(FilmDto $film): array
    {
        $characters = [];
        foreach ($film->characters as $characterUrl) {
            try {
                $characterData = $this->apiClient->getFromUrl($characterUrl);
                if (isset($characterData['result']['properties'])) {
                    $characters[] = [
                        'name' => $characterData['result']['properties']['name'],
                        'uid' => $characterData['result']['uid'] ?? null,
                        'url' => $characterUrl
                    ];
                }
            } catch (\Exception $e) {
                Log::warning("Failed to fetch character from {$characterUrl}: " . $e->getMessage());
                continue;
            }
        }
        return $characters;
    }
}
