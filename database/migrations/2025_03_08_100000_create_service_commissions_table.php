<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCommissionsTable extends Migration
{
    public function up()
    {
        Schema::create('service_commissions', function (Blueprint $table) {
            $table->id();
            $table->string('service_slug', 50)->unique()->comment('aeps, recharge, bbps, bus_booking, verification');
            $table->string('service_name', 100);
            $table->decimal('commission_percent', 5, 2)->default(0)->comment('Admin commission %');
            $table->decimal('commission_fixed', 10, 2)->default(0)->comment('Admin commission fixed amount');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_commissions');
    }
}
