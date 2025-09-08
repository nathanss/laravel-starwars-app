<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryStatistic extends Model
{
    protected $fillable = [
        'query',
        'request_time',
        'created_at'
    ];

    protected $casts = [
        'request_time' => 'float',
        'created_at' => 'datetime',
    ];
}
