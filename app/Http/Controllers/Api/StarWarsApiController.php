<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StarWarsApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StarWarsApiController extends Controller
{
    protected $starWarsService;

    public function __construct(StarWarsApiService $starWarsService)
    {
        $this->starWarsService = $starWarsService;
    }

    public function getPeople(Request $request): JsonResponse
    {
        $start = microtime(true);
        $result = $this->starWarsService->getPeople($request->query());
        $executionTime = microtime(true) - $start;

        event(new \App\Events\QueryExecuted('getPeople', $executionTime));
        return response()->json($result);
    }

    public function getPerson(string $id): JsonResponse
    {
        $start = microtime(true);
        $result = $this->starWarsService->getPerson($id);
        $executionTime = microtime(true) - $start;

        event(new \App\Events\QueryExecuted("getPerson/$id", $executionTime));
        return response()->json($result);
    }

    public function getFilms(Request $request): JsonResponse
    {
        $start = microtime(true);
        $result = $this->starWarsService->getFilms($request->query());
        $executionTime = microtime(true) - $start;

        event(new \App\Events\QueryExecuted('getFilms', $executionTime));
        return response()->json($result);
    }

    public function getFilm(string $id): JsonResponse
    {
        $start = microtime(true);
        $result = $this->starWarsService->getFilm($id);
        $executionTime = microtime(true) - $start;

        event(new \App\Events\QueryExecuted("getFilm/$id", $executionTime));
        return response()->json($result);
    }
}
