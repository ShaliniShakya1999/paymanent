<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKycSubmitCountToUserDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_details', function (Blueprint $table) {
            if (!Schema::hasColumn('user_details', 'kyc_submit_count')) {
                $table->unsignedTinyInteger('kyc_submit_count')->default(0)->after('kyc_rejection_reason')
                    ->comment('Number of times user has submitted KYC for verification (max 3)');
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
            if (Schema::hasColumn('user_details', 'kyc_submit_count')) {
                $table->dropColumn('kyc_submit_count');
            }
        });
    }
}
