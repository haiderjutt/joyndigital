<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PackageConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('administrators_num')->default('0');
            $table->string('operators_num')->default('0');
            $table->string('sites_num')->default('0');
            $table->string('agents_num')->default('0');
            $table->string('partner_num')->default('0');
            $table->string('package_type');
            $table->string('cost')->default('0');
            $table->string('cost_in_letters')->default('0');
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
        Schema::dropIfExists('packages');
    }
}
