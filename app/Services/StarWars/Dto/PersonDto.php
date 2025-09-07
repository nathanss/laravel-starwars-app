<?php

namespace App\Services\StarWars\Dto;

class PersonDto
{
    public string $name;
    public string $birth_year;
    public string $gender;
    public string $eye_color;
    public string $hair_color;
    public string $height;
    public string $mass;
    public array $films;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->name = $data['name'] ?? 'Unknown';
        $dto->birth_year = $data['birth_year'] ?? 'Unknown';
        $dto->gender = $data['gender'] ?? 'Unknown';
        $dto->eye_color = $data['eye_color'] ?? 'Unknown';
        $dto->hair_color = $data['hair_color'] ?? 'Unknown';
        $dto->height = $data['height'] ?? 'Unknown';
        $dto->mass = $data['mass'] ?? 'Unknown';
        $dto->films = $data['films'] ?? [];
        return $dto;
    }

    public static function createError(): self
    {
        return self::fromArray([
            'name' => 'Error loading person',
            'birth_year' => 'Unknown',
            'gender' => 'Unknown',
            'eye_color' => 'Unknown',
            'hair_color' => 'Unknown',
            'height' => 'Unknown',
            'mass' => 'Unknown',
            'films' => []
        ]);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'birth_year' => $this->birth_year,
            'gender' => $this->gender,
            'eye_color' => $this->eye_color,
            'hair_color' => $this->hair_color,
            'height' => $this->height,
            'mass' => $this->mass,
            'films' => $this->films
        ];
    }
}
