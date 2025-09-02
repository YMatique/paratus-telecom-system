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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
                $table->string('name');
            $table->string('description')->nullable();
            $table->integer('download_speed'); // Mbps
            $table->integer('upload_speed'); // Mbps
            $table->decimal('price', 10, 2); // Meticais (MT)
            $table->enum('billing_cycle', ['monthly', 'quarterly', 'annual'])->default('monthly');
            $table->boolean('unlimited_data')->default(true);
            $table->integer('data_limit_gb')->nullable(); // Se não for ilimitado
            $table->enum('connection_type', ['fiber', 'radio', 'adsl'])->default('fiber');
            $table->enum('customer_type', ['individual', 'company', 'both'])->default('both');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
