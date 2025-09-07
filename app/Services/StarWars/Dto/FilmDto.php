<?php

namespace App\Services\StarWars\Dto;

class FilmDto
{
    public string $title;
    public int $episode_id;
    public string $opening_crawl;
    public string $director;
    public string $producer;
    public string $release_date;
    public array $characters;
    public ?string $uid;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->title = $data['title'] ?? 'Unknown';
        $dto->episode_id = $data['episode_id'] ?? 0;
        $dto->opening_crawl = $data['opening_crawl'] ?? '';
        $dto->director = $data['director'] ?? 'Unknown';
        $dto->producer = $data['producer'] ?? 'Unknown';
        $dto->release_date = $data['release_date'] ?? 'Unknown';
        $dto->characters = $data['characters'] ?? [];
        $dto->uid = $data['uid'] ?? null;
        return $dto;
    }

    public static function createError(): self
    {
        return self::fromArray([
            'title' => 'Error loading film',
            'episode_id' => 0,
            'opening_crawl' => '',
            'director' => 'Unknown',
            'producer' => 'Unknown',
            'release_date' => 'Unknown',
            'characters' => []
        ]);
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'episode_id' => $this->episode_id,
            'opening_crawl' => $this->opening_crawl,
            'director' => $this->director,
            'producer' => $this->producer,
            'release_date' => $this->release_date,
            'characters' => $this->characters,
            'uid' => $this->uid
        ];
    }
}
