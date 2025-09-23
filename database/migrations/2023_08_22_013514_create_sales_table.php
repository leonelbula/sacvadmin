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
            $table->integer('subtotal');
            $table->integer('total_iva');
            $table->integer('total');
            $table->float('balance');
            $table->time('hour', $precision = 0);
            $table->date('date_sale');
            $table->string('term',50);
            $table->date('expiration_date');
            $table->integer('type_sale');
            $table->string('payment_form');
            $table->integer('payment_method')->nullable();
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
