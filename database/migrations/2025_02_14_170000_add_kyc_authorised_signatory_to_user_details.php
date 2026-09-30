<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKycAuthorisedSignatoryToUserDetails extends Migration
{
    public function up()
    {
        Schema::table('user_details', function (Blueprint $table) {
            if (!Schema::hasColumn('user_details', 'kyc_signatory_name')) {
                $table->string('kyc_signatory_name', 191)->nullable()->after('kyc_business_registration_other_name');
            }
            if (!Schema::hasColumn('user_details', 'kyc_signatory_phone')) {
                $table->string('kyc_signatory_phone', 20)->nullable()->after('kyc_signatory_name');
            }
            if (!Schema::hasColumn('user_details', 'kyc_signatory_email')) {
                $table->string('kyc_signatory_email', 191)->nullable()->after('kyc_signatory_phone');
            }
        });
    }

    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $cols = ['kyc_signatory_name', 'kyc_signatory_phone', 'kyc_signatory_email'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('user_details', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}
