<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aeps_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('reference_id', 64)->unique()->index();
            $table->string('bank_id', 64)->nullable();
            $table->string('bank_name', 191)->nullable();
            $table->string('aadhaar_masked', 16)->nullable();
            $table->decimal('amount', 16, 2)->default(0);
            $table->json('api_response')->nullable();
            $table->string('status', 32)->default('pending')->index();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aeps_transactions');
    }
};
