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
        Schema::create('linker_order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('linker_orders');
            $table->foreignId('product_id')->constrained('linker_products');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->timestamps();

            $table->index('product_id');
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linker_order_products');
    }
};
