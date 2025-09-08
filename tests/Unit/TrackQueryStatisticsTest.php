<?php

namespace Tests\Unit;

use App\Events\QueryExecuted;
use App\Listeners\TrackQueryStatistics;
use App\Models\QueryStatistic;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackQueryStatisticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_listener_creates_query_statistic(): void
    {
        $event = new QueryExecuted('testQuery', 0.5);
        $listener = new TrackQueryStatistics();

        $listener->handle($event);

        $this->assertDatabaseHas('query_statistics', [
            'query' => 'testQuery',
            'request_time' => 0.5
        ]);
    }

    public function test_multiple_queries_are_tracked(): void
    {
        $listener = new TrackQueryStatistics();

        $listener->handle(new QueryExecuted('query1', 0.5));
        $listener->handle(new QueryExecuted('query2', 0.3));
        $listener->handle(new QueryExecuted('query1', 0.4));

        $this->assertDatabaseCount('query_statistics', 3);

        $stats = QueryStatistic::where('query', 'query1')->get();
        $this->assertCount(2, $stats);
        $this->assertEquals([0.5, 0.4], $stats->pluck('request_time')->toArray());
    }
}
