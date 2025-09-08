<?php

namespace Tests\Feature;

use App\Jobs\ComputeQueryStatistics;
use App\Models\QueryStatistic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MetricsTest extends TestCase
{
    use RefreshDatabase;

    public function test_metrics_endpoint_returns_correct_structure(): void
    {
        $response = $this->get('/api/metrics');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'top_queries',
                'avg_request_time',
                'most_popular_hour',
                'last_computed'
            ]);
    }

    public function test_query_statistics_are_tracked(): void
    {
        $this->assertDatabaseCount('query_statistics', 0);

        // Make some API calls
        $this->get('/api/star-wars/people');
        $this->get('/api/star-wars/films');
        $this->get('/api/star-wars/people/1');

        $stats = QueryStatistic::all();

        // Check if statistics were recorded
        $this->assertDatabaseCount('query_statistics', 3);

        $stats = QueryStatistic::all();

        // Verify the types of queries recorded
        $this->assertContains('getPeople', $stats->pluck('query')->toArray());
        $this->assertContains('getFilms', $stats->pluck('query')->toArray());
        $this->assertContains('getPerson/1', $stats->pluck('query')->toArray());

        // Verify request times are being recorded
        foreach ($stats as $stat) {
            $this->assertIsFloat($stat->request_time);
            $this->assertGreaterThan(0, $stat->request_time);
        }
    }

    public function test_statistics_computation_job(): void
    {
        // Create some test data
        QueryStatistic::create(['query' => 'getPeople', 'request_time' => 0.5]);
        QueryStatistic::create(['query' => 'getPeople', 'request_time' => 0.3]);
        QueryStatistic::create(['query' => 'getFilms', 'request_time' => 0.2]);
        QueryStatistic::create(['query' => 'getPerson/1', 'request_time' => 0.4]);

        // Run the computation job
        ComputeQueryStatistics::dispatchSync();

        // Get the cached statistics
        $stats = Cache::get('query_statistics');

        $this->assertNotNull($stats);
        $this->assertArrayHasKey('top_queries', $stats);
        $this->assertArrayHasKey('avg_request_time', $stats);
        $this->assertArrayHasKey('most_popular_hour', $stats);
        $this->assertArrayHasKey('last_computed', $stats);

        // Verify top queries
        $this->assertEquals('getPeople', $stats['top_queries'][0]['query']);
        $this->assertEquals(2, $stats['top_queries'][0]['count']);
        $this->assertEquals(50.0, $stats['top_queries'][0]['percentage']);

        // Verify average request time
        $this->assertEquals(0.35, $stats['avg_request_time']);
    }

    public function test_metrics_update_every_five_minutes(): void
    {
        // Initial computation
        ComputeQueryStatistics::dispatchSync();
        $initialStats = Cache::get('query_statistics');

        // Add new statistics
        QueryStatistic::create(['query' => 'getFilm/1', 'request_time' => 0.6]);

        // Verify cache hasn't updated immediately
        $this->assertEquals(
            $initialStats,
            Cache::get('query_statistics')
        );

        // Force cache expiration and recompute
        Cache::forget('query_statistics');
        ComputeQueryStatistics::dispatchSync();

        // Verify stats have been updated
        $newStats = Cache::get('query_statistics');
        $this->assertNotEquals($initialStats, $newStats);
    }
}
