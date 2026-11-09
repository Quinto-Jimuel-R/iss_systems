<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVpnFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('vpn_forms', function (Blueprint $table) {
            $table->id();
            $table->string('control_no');
            $table->string('emp_no');
            $table->string('name');
            $table->string('department_section');
            $table->string('position');
            $table->string('type_of_request');
            $table->string('purpose');
            $table->date('date_from');
            $table->date('date_to');
            $table->string('access_location');
            $table->string('device_name');
            $table->string('asset_tag');
            $table->json('vpn_iss_details')->nullable();
            $table->tinyInteger('status')->comment('1=iss_manger, 2=assistant_vice_president, 3=president, 4=iss_hardware, 5=approved, 6=disapproved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_rapidx')->dropIfExists('vpn_forms');
    }
}