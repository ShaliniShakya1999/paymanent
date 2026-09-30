<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBusinessRegistrationTypeToUserDetails extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('user_details', 'business_registration_type')) {
            return;
        }
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('business_registration_type', 50)->nullable()->after('kyc_rejection_reason');
        });
    }

    public function down()
    {
        if (Schema::hasColumn('user_details', 'business_registration_type')) {
            Schema::table('user_details', function (Blueprint $table) {
                $table->dropColumn('business_registration_type');
            });
        }
    }
}
