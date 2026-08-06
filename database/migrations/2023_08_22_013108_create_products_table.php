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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code', 150);
            $table->string('name', 150);
            $table->integer('cost');
            $table->integer('price');
            $table->integer('utility');
            $table->integer('stock_min');
            $table->integer('stock');        
            $table->boolean('state')->default(1); 
            $table->foreignId('tax_id')->constrained('taxes')->onUpdate('cascade')->onDelete('restrict');         
            $table->foreignId('category_id')->constrained('categories')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
