<?php

namespace App\Jobs;

use App\Models\QueryStatistic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComputeQueryStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Top 5 queries with percentages
        $totalQueries = QueryStatistic::count();
        $topQueries = QueryStatistic::select('query', DB::raw('COUNT(*) as count'))
            ->groupBy('query')
            ->orderByDesc('count')
            ->limit(5)
            ->get()
            ->map(function ($item) use ($totalQueries) {
                return [
                    'query' => $item->query,
                    'count' => $item->count,
                    'percentage' => round(($item->count / $totalQueries) * 100, 2)
                ];
            });

        // Average request time
        $avgRequestTime = QueryStatistic::avg('request_time');

        // Most popular hour for searches
        $popularHour = QueryStatistic::select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderByDesc('count')
            ->first();

        $stats = [
            'top_queries' => $topQueries,
            'avg_request_time' => round($avgRequestTime, 3),
            'most_popular_hour' => $popularHour ? [
                'hour' => $popularHour->hour,
                'count' => $popularHour->count
            ] : null,
            'last_computed' => now()->toIso8601String()
        ];

        Cache::put('query_statistics', $stats, now()->addMinutes(5));
    }
}
