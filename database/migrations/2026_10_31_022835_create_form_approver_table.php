<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormApproverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('form_approver', function (Blueprint $table) {
            $table->id();
            $table->string('fk_control_no');
            $table->string('form_type');
            
            $table->string('iss_manager')->default(3);
            $table->date('iss_manager_date')->nullable();
            $table->string('iss_manager_remarks')->nullable();
            $table->string('iss_manager_approval_status')->default(1)->comment('1=pending, 2=approved, 3=disapproved');

            $table->string('admin_avp')->default(15);
            $table->date('admin_avp_date')->nullable();
            $table->string('admin_avp_remarks')->nullable();
            $table->string('admin_avp_approval_status')->default(1)->comment('1=pending, 2=approved, 3=disapproved');
            
            $table->string('admin_president')->default(147);
            $table->date('admin_president_date')->nullable();
            $table->string('admin_president_remarks')->nullable();
            $table->string('admin_president_approval_status')->default(1)->comment('1=pending, 2=approved, 3=disapproved');
            
            $table->string('iss_hardware')->nullable();
            $table->date('iss_hardware_date')->nullable();
            $table->string('iss_hardware_remarks')->nullable();
            
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
        Schema::connection('mysql_rapidx')->dropIfExists('form_approver');
    }
}