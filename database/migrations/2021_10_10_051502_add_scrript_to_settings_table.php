<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScrriptToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('google_analytics')->nullable();
            $table->text('google_adsense')->nullable();
            $table->text('facebook_pixel')->nullable();
            $table->text('facebook_messenger')->nullable();
            $table->tinyInteger('is_google_analytics')->default(0)->nullable();
            $table->tinyInteger('is_google_adsense')->default(0)->nullable();
            $table->tinyInteger('is_facebook_pixel')->default(0)->nullable();
            $table->tinyInteger('is_facebook_messenger')->default(0)->nullable();
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
                'google_analytics',
                'google_adsense',
                'facebook_pixel',
                'facebook_messenger',
                'is_google_analytics',
                'is_google_adsense',
                'is_facebook_pixel',
                'is_facebook_messenger'
            );
        });
    }
}
