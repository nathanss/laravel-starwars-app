<?php

namespace App\Http\Controllers;

use App\Services\StarWars\StarWarsService;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class StarWarsController extends Controller
{
    public function __construct(
        protected StarWarsService $starWarsService
    ) {}

    public function showPerson(string $id): Response
    {
        try {
            $data = $this->starWarsService->getPersonWithFilms($id);
            return Inertia::render('person', $data);
        } catch (\Exception $e) {
            Log::error("Controller error showing person {$id}: " . $e->getMessage());
            abort(500, 'Unable to load person details');
        }
    }

    public function showFilm(string $id): Response
    {
        try {
            $data = $this->starWarsService->getFilmWithCharacters($id);
            return Inertia::render('movie', $data);
        } catch (\Exception $e) {
            Log::error("Controller error showing film {$id}: " . $e->getMessage());
            abort(500, 'Unable to load film details');
        }
    }
}
