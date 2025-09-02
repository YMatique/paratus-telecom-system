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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['individual', 'company']); // Pessoa física ou jurídica
            $table->string('name');
            $table->string('document')->unique(); // BI, NUIT, Passaporte
            $table->enum('document_type', ['bi', 'nuit', 'passport']);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            // $table->date('birth_date')->nullable(); //
            $table->string('company_name')->nullable(); // Para PJ
            $table->enum('status', ['active', 'suspended', 'inactive'])->default('active');
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
        Schema::dropIfExists('customers');
    }
};
