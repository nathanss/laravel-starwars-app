<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class MetricsController extends Controller
{
    public function index(): JsonResponse
    {
        $stats = Cache::get('query_statistics', [
            'top_queries' => [],
            'avg_request_time' => 0,
            'most_popular_hour' => null,
            'last_computed' => null
        ]);

        return response()->json($stats);
    }
}
