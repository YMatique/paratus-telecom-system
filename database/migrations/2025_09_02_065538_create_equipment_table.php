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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->string('serial_number')->unique();
            $table->string('mac_address')->unique()->nullable();
            $table->enum('status', ['available', 'installed', 'maintenance', 'damaged', 'lost']);
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->date('installation_date')->nullable();
            $table->date('return_date')->nullable();
            $table->text('location_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
