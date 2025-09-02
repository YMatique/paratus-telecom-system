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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained();
            $table->foreignId('installation_address_id')->constrained('addresses');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'suspended', 'cancelled', 'pending_installation']);
            $table->decimal('monthly_price', 10, 2); // Preço no momento da contratação
            $table->decimal('installation_fee', 10, 2)->default(0);
            $table->boolean('auto_renew')->default(true);
            $table->integer('billing_day')->default(1); // Dia do vencimento (1-28)
            $table->date('last_invoice_date')->nullable();
            $table->date('next_invoice_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
