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
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->string('email_token')->nullable();
            $table->string('password')->nullable();
            $table->string('ship_address1')->nullable();
            $table->string('ship_address2')->nullable();
            $table->string('ship_zip')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_country')->nullable();
            $table->string('ship_company')->nullable();
            $table->string('bill_address1')->nullable();
            $table->string('bill_address2')->nullable();
            $table->string('bill_zip')->nullable();
            $table->string('bill_city')->nullable();
            $table->string('bill_country')->nullable();
            $table->string('bill_company')->nullable();
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
        Schema::dropIfExists('users');
    }
}
