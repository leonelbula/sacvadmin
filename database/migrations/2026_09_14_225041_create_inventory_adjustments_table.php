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
        Schema::create('inventory_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();

            $table->enum('movement_type', [
                'income',
                'output'
            ]);
            $table->integer('stock_before');
            $table->integer('stock_after');

            $table->unsignedInteger('quantity');

            $table->text('observation')->nullable();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->index('movement_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustments');
    }
};
