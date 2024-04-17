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
            $table->string('header_menu_categories')->nullable()->after('linkedin_url');
            $table->string('footer_menu_categories')->nullable()->after('header_menu_categories');
            $table->string('filters_categories')->nullable()->after('footer_menu_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
        });
    }
};
