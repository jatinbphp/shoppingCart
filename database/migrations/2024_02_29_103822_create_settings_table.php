<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email_address')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            'address'       => '3298 Grant Street Longview, TX United Kingdom 75601',
            'phone_number'  => '1-202-555-0106',
            'email_address' => 'help@shopper.com',
            'facebook_url'  => 'https://www.facebook.com/',
            'twitter_url'   => 'https://in.linkedin.com/company/twitter',
            'youtube_url'   => 'https://www.youtube.com/',
            'instagram_url' => 'https://www.instagram.com/',
            'linkedin_url'  => 'https://in.linkedin.com/',
            'status'        => 1,
            'created_at'    => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('header_menu');
            $table->string('footer_menu');
        });
    }
};
