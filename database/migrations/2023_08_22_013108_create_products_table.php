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
            $table->float('cost');
            $table->float('price');
            $table->float('utility');
            $table->float('minimum_amount');
            $table->float('amount');
            $table->string('image', 255);
            $table->boolean('state');
            $table->foreignId('category_id')->constrained('categories')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade')->onDelete('restrict');
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
