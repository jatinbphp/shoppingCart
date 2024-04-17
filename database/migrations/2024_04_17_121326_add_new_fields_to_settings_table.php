<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('image')->nullable()->after('breadcrumb_image')->nullable();
            $table->string('first_title')->nullable()->after('image')->nullable();
            $table->string('second_title')->nullable()->after('first_title')->nullable();
            $table->longText('content')->nullable()->after('second_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
