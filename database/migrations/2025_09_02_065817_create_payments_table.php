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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('invoice_id')->nullable()->constrained();
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cash', 'bank_transfer', 'mpesa', 'emola', 'mkesh', 'card']);
            $table->string('reference')->nullable(); // Referência do pagamento
            $table->date('payment_date');
            $table->enum('status', ['pending', 'confirmed', 'failed', 'refunded']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
