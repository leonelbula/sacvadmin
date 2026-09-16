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
        Schema::create('sale_returns_details', function (Blueprint $table) {
            $table->id();
            // Devolución
            $table->foreignId('sale_return_id')
                ->constrained('sale_returns')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Producto devuelto
            $table->foreignId('product_id')
                ->constrained('products')
                ->onUpdate('cascade')
                ->onDelete('restrict');


            // Cantidad devuelta
            $table->integer('quantity');

            // Precio al que se vendió
            $table->integer('price');

            // costo
            $table->integer('cost');

            // Total de esta línea
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_returns_details');
    }
};
