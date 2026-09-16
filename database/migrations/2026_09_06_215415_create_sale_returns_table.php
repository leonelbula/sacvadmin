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
        Schema::create('sale_returns', function (Blueprint $table) {
            $table->id();
            // Número consecutivo de la devolución
            $table->integer('return_number');



            // Cliente de la venta
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            // Usuario que registra la devolución
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->integer('cost')->default(0);
            // Total de la devolución
            $table->integer('total')->default(0);

            // Motivo
            $table->string('reason', 50);

            // Tipo de devolución:
            // cash       = devolución de dinero
            // balance    = saldo a favor
            // exchange   = cambio por producto
            $table->string('refund_type', 30);

            // Estado:
            // pending    = pendiente
            // completed  = completada
            // cancelled  = anulada
            $table->string('state', 30)->default('completed');

            $table->text('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_returns');
    }
};
