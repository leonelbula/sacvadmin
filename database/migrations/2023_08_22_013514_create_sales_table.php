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
            $table->float('cost');
            $table->float('utility');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total_iva', 10, 2);
            $table->decimal('total', 10, 2);
            $table->float('balance');
            $table->time('hour', $precision = 0);
            $table->date('date_sale');
            $table->string('term',50);
            $table->date('expiration_date');
            $table->integer('type_sale');
            $table->integer('payment_form');
            $table->integer('payment_method');
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
