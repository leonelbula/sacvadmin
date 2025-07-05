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
        Schema::create('start_sales', function (Blueprint $table) {
            $table->id();
            $table->float('base_box');
            $table->float('sale_total');
            $table->float('delivered_value');
            $table->float('difference');
            $table->float('spent');
            $table->float('return_value');
            $table->time('Start_Time', $precision = 0);
            $table->time('closing_time', $precision = 0);
            $table->boolean('state');
            $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('start_sales');
    }
};
