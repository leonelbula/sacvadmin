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
            $table->integer('identification_document_code');
            $table->boolean('state')->default(1);
            $table->foreignId('customer_tribute_id')->constrained('customer_tributes')->onUpdate('cascade')->onDelete('restrict');
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
