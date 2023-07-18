<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('loader')->nullable();
            $table->tinyInteger('is_loader')->default(1)->nullable();
            $table->string('feature_image')->nullable();
            $table->string('primary_color')->nullable();
            $table->tinyInteger('smtp_check')->default(0)->nullable();
            $table->string('email_host')->nullable();
            $table->string('email_port')->nullable();
            $table->string('email_encryption')->nullable();
            $table->string('email_user')->nullable();
            $table->string('email_pass')->nullable();
            $table->string('email_from')->nullable();
            $table->string('email_from_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('version')->nullable();
            $table->text('overlay')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('is_shop')->default(1)->nullable();
            $table->tinyInteger('is_blog')->default(1)->nullable();
            $table->tinyInteger('is_faq')->default(1)->nullable();
            $table->tinyInteger('is_contact')->default(1)->nullable();
            $table->tinyInteger('facebook_check')->default(1)->nullable();
            $table->string('facebook_client_id')->nullable();
            $table->string('facebook_client_secret')->nullable();
            $table->string('facebook_redirect')->nullable();
            $table->tinyInteger('google_check')->default(1)->nullable();
            $table->string('google_client_id')->nullable();
            $table->string('google_client_secret')->nullable();
            $table->string('google_redirect')->nullable();
            $table->double('min_price')->default(0)->nullable();
            $table->double('max_price')->default(100000)->nullable();
            $table->string('footer_phone')->nullable();
            $table->text('footer_address')->nullable();
            $table->string('footer_email')->nullable();
            $table->string('footer_gateway_img')->nullable();
            $table->text('social_link')->nullable();
            $table->string('friday_start')->nullable();
            $table->string('friday_end')->nullable();
            $table->string('satureday_start')->nullable();
            $table->string('satureday_end')->nullable();
            $table->string('copy_right')->nullable();
            $table->tinyInteger('is_slider')->default(1)->nullable();
            $table->tinyInteger('is_category')->default(1)->nullable();
            $table->tinyInteger('is_product')->default(1)->nullable();
            $table->tinyInteger('is_top_banner')->default(1)->nullable();
            $table->tinyInteger('is_recent')->default(1)->nullable();
            $table->tinyInteger('is_top')->default(1)->nullable();
            $table->tinyInteger('is_best')->default(1)->nullable();
            $table->tinyInteger('is_flash')->default(1)->nullable();
            $table->tinyInteger('is_brand')->default(1)->nullable();
            $table->tinyInteger('is_blogs')->default(1)->nullable();
            $table->tinyInteger('is_campaign')->default(1)->nullable();
            $table->tinyInteger('is_brands')->default(1)->nullable();
            $table->tinyInteger('is_bottom_banner')->default(1)->nullable();
            $table->tinyInteger('is_service')->default(1)->nullable();
            $table->string('campaign_title')->nullable();
            $table->string('campaign_end_date')->nullable();
            $table->tinyInteger('campaign_status')->default(1)->nullable();
            $table->string('twilio_sid')->nullable();
            $table->string('twilio_token')->nullable();
            $table->string('twilio_form_number')->nullable();
            $table->string('twilio_country_code')->nullable();
            $table->tinyInteger('is_announcement')->default(1)->nullable();
            $table->string('announcement', 255)->nullable();
            $table->decimal('announcement_delay', 11, 2)->default(0.00);
            $table->tinyInteger('is_maintainance')->default(1)->nullable();
            $table->string('maintainance_image')->nullable();
            $table->text('maintainance_text')->nullable();
            $table->tinyInteger('is_twilio')->default(0)->nullable();
            $table->text('twilio_section')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
