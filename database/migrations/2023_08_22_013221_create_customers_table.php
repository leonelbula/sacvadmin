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
            $table->string('identification');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->integer('credit_amount');
            $table->foreignId('departament_id')->constrained('departaments')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('city_id')->constrained('cities')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('customer_tribute_id')->constrained('customer_tributes')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('identification_document_id')->constrained('identity_documents')->onUpdate('cascade')->onDelete('restrict');
            $table->string('responsibilities', 255);
            $table->foreignId('organization_type_id')->constrained('organization_types')->onUpdate('cascade')->onDelete('restrict');
            $table->boolean('state')->default(1);
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
