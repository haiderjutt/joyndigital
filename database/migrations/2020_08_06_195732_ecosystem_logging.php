<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EcosystemLogging extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('system_personal_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('activity_by');
            $table->timestamp('activity_at');
            $table->string('activity')->nullable();
            $table->string('activity_type')->nullable();
            $table->string('activity_on')->nullable();
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
        Schema::dropIfExists('system_personal_log');
    }
}
