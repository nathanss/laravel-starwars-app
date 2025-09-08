<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('query_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('query');
            $table->float('request_time')->comment('Request processing time in seconds');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('query_statistics');
    }
};
