<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('text')->nullable();
            $table->string('slug')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_descriptions')->nullable();
            $table->tinyInteger('status')->default()->nullable();
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
        Schema::dropIfExists('fcategories');
    }
}
