<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recharge_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('operator_id', 50)->nullable();
            $table->string('operator_name', 100)->nullable();
            $table->string('mobile', 20);
            $table->decimal('amount', 16, 2);
            $table->string('reference_id', 64)->unique();
            $table->string('status', 32)->default('pending');
            $table->json('api_request')->nullable();
            $table->json('api_response')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'created_at']);
            $table->index('reference_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recharge_transactions');
    }
};
