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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('address_id')->default(0);
            $table->string('total_amount')->default(0);
            $table->string('status')->default('pending');
            $table->string('delivey_method')->default('Next Day Delivery (order before 12pm)');
            $table->string('notes')->nullable();
            $table->longText('address_info')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
