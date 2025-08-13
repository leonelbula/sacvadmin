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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->string('identification_card', 20);
            $table->string('phone', 50);
            $table->string('email', 50);
            $table->string('address', 50);
            $table->string('city', 50);
            $table->string('Departament', 50);
            $table->float('credit_amount');
            $table->string('description', 150);
            $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
