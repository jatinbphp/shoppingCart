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
        Schema::create('order_stock_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('type');
            $table->integer('product_id');
            $table->integer('option_id_value_1');
            $table->integer('option_id_value_2');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_stock_histories');
    }
};
