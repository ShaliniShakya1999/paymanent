<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKycFieldsToUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_details', function (Blueprint $table) {
            if (!Schema::hasColumn('user_details', 'merchant_category')) {
                $table->string('merchant_category', 30)->nullable()->after('timezone')
                    ->comment('individual, proprietorship, partnership');
            }
            if (!Schema::hasColumn('user_details', 'kyc_status')) {
                $table->string('kyc_status', 20)->default('pending')->after('merchant_category')
                    ->comment('pending, in_review, approved, rejected');
            }
            if (!Schema::hasColumn('user_details', 'kyc_submitted_at')) {
                $table->timestamp('kyc_submitted_at')->nullable()->after('kyc_status');
            }
            if (!Schema::hasColumn('user_details', 'kyc_reviewed_at')) {
                $table->timestamp('kyc_reviewed_at')->nullable()->after('kyc_submitted_at');
            }
            if (!Schema::hasColumn('user_details', 'kyc_rejection_reason')) {
                $table->text('kyc_rejection_reason')->nullable()->after('kyc_reviewed_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $cols = ['merchant_category', 'kyc_status', 'kyc_submitted_at', 'kyc_reviewed_at', 'kyc_rejection_reason'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('user_details', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}
