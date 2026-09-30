<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKycPartnersTable extends Migration
{
    public function up()
    {
        Schema::create('kyc_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->string('aadhaar_number', 12)->nullable();
            $table->unsignedInteger('aadhaar_file_id')->nullable();
            $table->string('pan_number', 10)->nullable();
            $table->unsignedInteger('pan_file_id')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kyc_partners');
    }
}
