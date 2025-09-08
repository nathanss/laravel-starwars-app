<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueryExecuted
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $query,
        public float $executionTime
    ) {}
}
