<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TemplateCustomerFieldsConfig extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('customer_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('destination_id'); 
            $table->string('field_name'); 
            $table->string('field_type'); 
            $table->string('single_select')->default('no'); 
            $table->string('multi_select')->default('no');
            $table->json('perm')->nullable();  
            
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
        Schema::dropIfExists('templates');
    }
}
