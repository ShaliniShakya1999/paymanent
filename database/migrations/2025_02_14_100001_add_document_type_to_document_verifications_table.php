<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentTypeToDocumentVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('document_verifications', function (Blueprint $table) {
            $table->string('document_type', 50)->nullable()->after('identity_number')
                ->comment('pan, aadhaar_front, aadhaar_back, photo, business_proof, gst_certificate, partnership_deed, etc.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('document_verifications', function (Blueprint $table) {
            $table->dropColumn('document_type');
        });
    }
}
