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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('model')->nullable();
            $table->string('brand')->nullable();
            $table->enum('category', ['modem', 'router', 'onu', 'antenna', 'cable', 'other']);
            $table->text('description')->nullable();
            $table->decimal('sale_price', 10, 2)->nullable(); // Preço de venda
            $table->decimal('rental_price', 10, 2)->nullable(); // Preço de aluguel mensal
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_stock_alert')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
