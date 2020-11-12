<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AssignmentConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('assignment_config', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('worker_id');
            $table->string('customer_id');
            $table->string('role');
            $table->string('error_num')->default('0');
            $table->string('success_num')->default('0');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('assignment_config');
    }
}
