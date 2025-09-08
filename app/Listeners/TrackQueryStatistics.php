<?php

namespace App\Listeners;

use App\Events\QueryExecuted;
use App\Models\QueryStatistic;

class TrackQueryStatistics
{
    public function handle(QueryExecuted $event): void
    {
        QueryStatistic::create([
            'query' => $event->query,
            'request_time' => $event->executionTime,
        ]);
    }
}
