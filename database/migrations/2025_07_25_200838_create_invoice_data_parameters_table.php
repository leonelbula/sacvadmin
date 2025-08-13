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
        Schema::create('invoice_data_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('range_id');
            $table->string('document');
            $table->string('prefix');
            $table->integer('from');//numero inicial de rango de numeracion
            $table->integer('to');//numero final de rango numetacion
            $table->integer('current');
            $table->integer('resolution_number');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_data_parameters');
    }
};
