<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_request_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('module', 32);
            $table->string('endpoint', 255)->nullable();
            $table->string('method', 10)->default('POST');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('reference_id', 64)->nullable();
            $table->unsignedSmallInteger('response_status')->nullable();
            $table->json('request_headers_masked')->nullable();
            $table->json('request_body_masked')->nullable();
            $table->json('response_body')->nullable();
            $table->string('error_message', 500)->nullable();
            $table->float('duration_ms', 10, 2)->nullable();
            $table->timestamps();
            $table->index(['module', 'created_at']);
            $table->index('reference_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_request_logs');
    }
};
