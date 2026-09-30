<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_request_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('module', 32)->index();
            $table->string('action', 64)->index();
            $table->string('reference_id', 64)->nullable()->index();
            $table->string('request_url', 512)->nullable();
            $table->json('request_headers_masked')->nullable();
            $table->json('request_body_masked')->nullable();
            $table->unsignedSmallInteger('response_status')->nullable();
            $table->json('response_body_summary')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_request_logs');
    }
};
