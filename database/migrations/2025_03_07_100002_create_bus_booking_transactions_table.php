<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus_booking_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('reference_id', 64)->index();
            $table->string('pnr', 64)->nullable()->index();
            $table->string('trip_id', 64)->nullable();
            $table->string('source_city_id', 64)->nullable();
            $table->string('source_city_name', 191)->nullable();
            $table->string('dest_city_id', 64)->nullable();
            $table->string('dest_city_name', 191)->nullable();
            $table->date('travel_date')->nullable();
            $table->json('passenger_details')->nullable();
            $table->decimal('amount', 16, 2)->default(0);
            $table->string('status', 32)->default('pending')->index();
            $table->json('api_response')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_ref', 64)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_booking_transactions');
    }
};
