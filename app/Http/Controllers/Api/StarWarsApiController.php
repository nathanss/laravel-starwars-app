<?php

namespace App\Http\Controllers\Api;

use App\Events\QueryExecuted;
use App\Http\Controllers\Controller;
use App\Services\StarWars\StarWarsApiClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StarWarsApiController extends Controller
{
    protected $starWarsService;

    public function __construct(StarWarsApiClient $starWarsService)
    {
        $this->starWarsService = $starWarsService;
    }

    public function getPeople(Request $request): JsonResponse
    {
        $start = microtime(true);
        $result = $this->starWarsService->getPeople($request->query());
        $executionTime = microtime(true) - $start;

        event(new QueryExecuted('getPeople', $executionTime));
        return response()->json($result);
    }

    public function getPerson(string $id): JsonResponse
    {
        $start = microtime(true);
        $result = $this->starWarsService->getPerson($id);
        $executionTime = microtime(true) - $start;

        event(new QueryExecuted("getPerson/$id", $executionTime));
        return response()->json($result);
    }

    public function getFilms(Request $request): JsonResponse
    {
        $start = microtime(true);
        $result = $this->starWarsService->getFilms($request->query());
        $executionTime = microtime(true) - $start;

        event(new QueryExecuted('getFilms', $executionTime));
        return response()->json($result);
    }

    public function getFilm(string $id): JsonResponse
    {
        $start = microtime(true);
        $result = $this->starWarsService->getFilm($id);
        $executionTime = microtime(true) - $start;

        event(new QueryExecuted("getFilm/$id", $executionTime));
        return response()->json($result);
    }
}
