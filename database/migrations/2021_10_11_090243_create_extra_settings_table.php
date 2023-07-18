<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_t4_slider')->default(1)->nullable();
            $table->tinyInteger('is_t4_featured_banner')->default(1)->nullable();
            $table->tinyInteger('is_t4_specialpick')->default(1)->nullable();
            $table->tinyInteger('is_t4_3_column_banner_first')->default(1)->nullable();
            $table->tinyInteger('is_t4_flashdeal')->default(1)->nullable();
            $table->tinyInteger('is_t4_3_column_banner_second')->default(1)->nullable();
            $table->tinyInteger('is_t4_popular_category')->default(1)->nullable();
            $table->tinyInteger('is_t4_2_column_banner')->default(1)->nullable();
            $table->tinyInteger('is_t4_blog_section')->default(1)->nullable();
            $table->tinyInteger('is_t4_brand_section')->default(1)->nullable();
            $table->tinyInteger('is_t4_service_section')->default(1)->nullable();

            $table->tinyInteger('is_t3_slider')->default(1)->nullable();
            $table->tinyInteger('is_t3_service_section')->default(1)->nullable();
            $table->tinyInteger('is_t3_3_column_banner_first')->default(1)->nullable();
            $table->tinyInteger('is_t3_popular_category')->default(1)->nullable();
            $table->tinyInteger('is_t3_flashdeal')->default(1)->nullable();
            $table->tinyInteger('is_t3_3_column_banner_second')->default(1)->nullable();
            $table->tinyInteger('is_t3_pecialpick')->default(1)->nullable();
            $table->tinyInteger('is_t3_brand_section')->default(1)->nullable();
            $table->tinyInteger('is_t3_2_column_banner')->default(1)->nullable();
            $table->tinyInteger('is_t3_blog_section')->default(1)->nullable();

            $table->tinyInteger('is_t2_slider')->default(1)->nullable();
            $table->tinyInteger('is_t2_service_section')->default(1)->nullable();
            $table->tinyInteger('is_t2_3_column_banner_first')->default(1)->nullable();
            $table->tinyInteger('is_t2_flashdeal')->default(1)->nullable();
            $table->tinyInteger('is_t2_new_product')->default(1)->nullable();
            $table->tinyInteger('is_t2_3_column_banner_second')->default(1)->nullable();
            $table->tinyInteger('is_t2_featured_product')->default(1)->nullable();
            $table->tinyInteger('is_t2_bestseller_product')->default(1)->nullable();
            $table->tinyInteger('is_t2_toprated_product')->default(1)->nullable();
            $table->tinyInteger('is_t2_2_column_banner')->default(1)->nullable();
            $table->tinyInteger('is_t2_blog_section')->default(1)->nullable();
            $table->tinyInteger('is_t2_brand_section')->default(1)->nullable();

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
        Schema::dropIfExists('extra_settings');
    }
}
