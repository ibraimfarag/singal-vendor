<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraVisibilityToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->tinyInteger('is_three_c_b_first')->default(1)->nullable();
            $table->tinyInteger('is_popular_category')->default(1)->nullable();
            $table->tinyInteger('is_three_c_b_second')->default(1)->nullable();
            $table->tinyInteger('is_highlighted')->default(1)->nullable();
            $table->tinyInteger('is_two_column_category')->default(1)->nullable();
            $table->tinyInteger('is_popular_brand')->default(1)->nullable();
            $table->tinyInteger('is_featured_category')->default(1)->nullable();
            $table->tinyInteger('is_two_c_b')->default(1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(
                'is_three_c_b_first',
                'is_popular_category',
                'is_three_c_b_second',
                'is_highlighted',
                'is_two_column_category',
                'is_popular_brand',
                'is_featured_category',
                'is_two_c_b'
            );
        });
    }
}
