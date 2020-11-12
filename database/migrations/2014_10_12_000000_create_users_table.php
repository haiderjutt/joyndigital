<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->string('phone')->nullable();
            $table->string('role')->nullable();
            $table->string('package_id')->nullable();
            $table->string('ban')->default('no');
            $table->string('auth_db')->default('no');
            $table->string('type')->nullable();
            $table->string('allowed_entries')->default('0');
            $table->string('entries_done')->default('0');
            $table->string('sidebar_switch')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
