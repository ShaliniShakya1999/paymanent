<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKycBusinessRegistrationFieldsToUserDetails extends Migration
{
    public function up()
    {
        Schema::table('user_details', function (Blueprint $table) {
            if (!Schema::hasColumn('user_details', 'kyc_business_registration_number')) {
                $table->string('kyc_business_registration_number', 100)->nullable()->after('business_registration_type');
            }
            if (!Schema::hasColumn('user_details', 'kyc_business_registration_other_name')) {
                $table->string('kyc_business_registration_other_name', 191)->nullable()->after('kyc_business_registration_number');
            }
        });
    }

    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $cols = ['kyc_business_registration_number', 'kyc_business_registration_other_name'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('user_details', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}
