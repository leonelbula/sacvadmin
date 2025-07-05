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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_number');
            $table->text('content');
            $table->float('cost');
            $table->float('utility');
            $table->float('total');
            $table->float('balance');
            $table->time('hour', $precision = 0);
            $table->date('date_sale');
            $table->date('expiration_date');
            $table->integer('type_sale');
            $table->foreignId('customer_id')->constrained('customers')->onUpdate('cascade')->onDelete('restrict');
           $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
