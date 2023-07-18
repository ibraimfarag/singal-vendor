<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->default(0)->nullable();
            $table->integer('subcategory_id')->default(0)->nullable();
            $table->integer('childcategory_id')->default(0)->nullable();
            $table->integer('tax_id')->nullable();
            $table->integer('brand_id')->default(0)->nullable();
            $table->text('name')->nullable();
            $table->text('slug')->nullable();
            $table->string('sku')->nullable();
            $table->text('tags')->nullable();
            $table->text('video')->nullable();
            $table->text('sort_details')->nullable();
            $table->text('specification_name')->nullable();
            $table->text('specification_description')->nullable();
            $table->tinyInteger('is_specification')->default(0)->nullable();
            $table->text('details')->nullable();
            $table->string('photo')->nullable();
            $table->double('discount_price')->default(0)->nullable();
            $table->double('previous_price')->default(0)->nullable();
            $table->integer('stock')->default(0)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('status')->default()->nullable();
            $table->string('is_type')->nullable();
            $table->string('date')->nullable();
            $table->enum('item_type',['normal', 'digital'])->default('normal');
            $table->string('file')->nullable();
            $table->text('link')->nullable();
            $table->enum('file_type',['file', 'link'])->nullable();
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
        Schema::dropIfExists('items');
    }
}
