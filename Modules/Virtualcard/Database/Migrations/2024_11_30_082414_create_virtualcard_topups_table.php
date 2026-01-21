<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVirtualcardTopupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('virtualcard_topups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('virtualcard_id')->constrained('virtualcards')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('requested_fund', 20, 8);
            $table->decimal('percentage', 20, 8)->nullable();
            $table->decimal('percentage_fees', 20, 8)->nullable();
            $table->decimal('fixed_fees', 20, 8)->nullable();
            $table->timestamp('fund_request_time')->nullable();
            $table->string('fund_approval_status', 11)->default('Pending')->comment('Pending, Approved, Cancelled');
            $table->string('cancellation_reason', 191)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtualcard_topups');
    }
}
