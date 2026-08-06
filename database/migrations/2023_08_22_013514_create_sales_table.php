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
            $table->integer('cost');
            $table->integer('utility');
            $table->integer('subtotal');         
            $table->integer('total');
            $table->integer('balance');
            $table->time('hour', $precision = 0);
            $table->date('date_sale');
            $table->string('term', 50);
            $table->date('expiration_date');
            $table->integer('type_sale');
            $table->string('payment_form');
            $table->string('observation', 150);
            $table->integer('taxes');
            $table->foreignId('customer_id')->constrained('customers')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('restrict')->unique();
            $table->string('state');
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
