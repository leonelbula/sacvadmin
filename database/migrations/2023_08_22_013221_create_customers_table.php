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
            $table->string('full_name');
            $table->string('identification_card');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->float('credit_amount');
            $table->foreignId('departament_id')->constrained('departaments')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('city_id')->constrained('cities')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('tax_id')->constrained('taxes')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('type_organice_id')->constrained('organization_types')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('identity_document_id')->constrained('identity_documents')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('customer_tribute_id')->constrained('customer_tributes')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
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
