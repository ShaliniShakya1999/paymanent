<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKycBankDetailsToUserDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_details', function (Blueprint $table) {
            if (!Schema::hasColumn('user_details', 'kyc_bank_name')) {
                $table->string('kyc_bank_name', 191)->nullable()->after('business_registration_type');
            }
            if (!Schema::hasColumn('user_details', 'kyc_bank_account_holder_name')) {
                $table->string('kyc_bank_account_holder_name', 191)->nullable()->after('kyc_bank_name');
            }
            if (!Schema::hasColumn('user_details', 'kyc_bank_account_number')) {
                $table->string('kyc_bank_account_number', 50)->nullable()->after('kyc_bank_account_holder_name');
            }
            if (!Schema::hasColumn('user_details', 'kyc_bank_ifsc_code')) {
                $table->string('kyc_bank_ifsc_code', 20)->nullable()->after('kyc_bank_account_number');
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
            $cols = ['kyc_bank_name', 'kyc_bank_account_holder_name', 'kyc_bank_account_number', 'kyc_bank_ifsc_code'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('user_details', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
}
