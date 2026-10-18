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
        Schema::create('acount_payable_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shopping_id')
                ->constrained('sales')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->integer('amount');
            $table->date('payment_date');
            $table->string('payment_method', 30);
            $table->string('reference', 100)->nullable();
            $table->text('observation')->nullable();


            $table->index(['shopping_id', 'payment_date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acount_payable_payments');
    }
};
