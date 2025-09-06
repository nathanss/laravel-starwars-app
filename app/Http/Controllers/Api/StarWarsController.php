<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StarWarsApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StarWarsController extends Controller
{
    protected $starWarsService;

    public function __construct(StarWarsApiService $starWarsService)
    {
        $this->starWarsService = $starWarsService;
    }

    public function getPeople(Request $request): JsonResponse
    {
        $result = $this->starWarsService->getPeople($request->query());
        return response()->json($result);
    }

    public function getPerson(string $id): JsonResponse
    {
        $result = $this->starWarsService->getPerson($id);
        return response()->json($result);
    }

    public function getFilms(Request $request): JsonResponse
    {
        $result = $this->starWarsService->getFilms($request->query());
        return response()->json($result);
    }

    public function getFilm(string $id): JsonResponse
    {
        $result = $this->starWarsService->getFilm($id);
        return response()->json($result);
    }
}
