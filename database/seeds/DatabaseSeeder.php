<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('extra_settings')->insert([
            'is_t4_slider' => '1',
            'is_t4_featured_banner' => '1',
            'is_t4_specialpick' => '1',
            'is_t4_3_column_banner_first' => '1',
            'is_t4_flashdeal' => '1',
            'is_t4_3_column_banner_second' => '1',
            'is_t4_popular_category' => '1',
            'is_t4_2_column_banner' => '1',
            'is_t4_blog_section' => '1',
            'is_t4_brand_section' => '1',
            'is_t4_service_section' => '1',
            'is_t3_slider' => '1',
            'is_t3_service_section' => '1',
            'is_t3_3_column_banner_first' => '1',
            'is_t3_popular_category' => '1',
            'is_t3_flashdeal' => '1',
            'is_t3_3_column_banner_second' => '1',
            'is_t3_pecialpick' => '1',
            'is_t3_brand_section' => '1',
            'is_t3_2_column_banner' => '1',
            'is_t3_blog_section' => '1',
            'is_t2_slider' => '1',
            'is_t2_service_section' => '1',
            'is_t2_3_column_banner_first' => '1',
            'is_t2_flashdeal' => '1',
            'is_t2_new_product' => '1',
            'is_t2_3_column_banner_second' => '1',
            'is_t2_featured_product' => '1',
            'is_t2_bestseller_product' => '1',
            'is_t2_toprated_product' => '1',
            'is_t2_2_column_banner' => '1',
            'is_t2_blog_section' => '1',
            'is_t2_brand_section' => '1'
        ]);

        DB::table('payment_settings')->insert([
            'name' => 'Mercadopago',
            'information' => '{"public_key":"TEST-6f72a502-51c8-4e9a-8ca3-cb7fa0addad8","token":"TEST-6068652511264159-022306-e78da379f3963916b1c7130ff2906826-529753482","check_sandbox":1}',
            'unique_keyword' => 'mercadopago',
            'photo' => '1633085560unnamed.jpeg',
            'text' => 'Mercadopago is the faster & safer way to send money. Make an online payment via Mercadopago.',
            'status' => '1',
        ]);

        DB::table('payment_settings')->insert([
            'name' => 'Authorize.Net',
            'information' => '{"login_id":"76zu9VgUSxrJ","txn_key":"2Vj62a6skSrP5U3X","check_sandbox":1}',
            'unique_keyword' => 'authorize',
            'photo' => '1633100640seal2.png',
            'text' => 'Authorize.Net is the faster & safer way to send money. Make an online payment via Authorize.Net',
            'status' => '1',
        ]);

        DB::table('payment_settings')->insert([
            'name' => 'Paystack',
            'information' => '{"key":"pk_test_162a56d42131cbb01932ed0d2c48f9cb99d8e8e2","email":"geniusdevs@gmail.com"}',
            'unique_keyword' => 'paystack',
            'photo' => '1634237632paystack-opengraph.png',
            'text' => 'Paystack is the faster & safer way to send money. Make an online payment via Paystack.',
            'status' => '1',
        ]);

        DB::table('payment_settings')->insert([
            'name' => 'Bank Transfer',
            'information' => null,
            'unique_keyword' => 'bank',
            'photo' => null,
            'text' => '<p>Account Number : 434 3434 3334</p><p>Pay With Bank Transfer.</p><p>Account Name : Jhon Due</p><p>Account Email : demo@gmail.com</p>',
            'status' => '1',
        ]);
    }
}
