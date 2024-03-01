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
            $table->softDeletes();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            'address'       => null,
            'phone_number'  => null,
            'email_address' => null,
            'facebook_url'  => null,
            'twitter_url'   => null,
            'youtube_url'   => null,
            'instagram_url' => null,
            'linkedin_url'  => null,
            'status'        => 1,
            'created_at'    => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
