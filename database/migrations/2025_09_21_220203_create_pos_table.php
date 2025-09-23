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
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->integer('box_base');
            $table->integer('total_sale');
            $table->float('difference');
            $table->time('start_time', $precision = 0);
            $table->time('closing_time', $precision = 0);
            $table->date('start_date');
            $table->date('closing_date');
            $table->integer('bills');
            $table->integer('returns');
            $table->integer('delivered_value');
            $table->boolean('state');
             $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('restrict')->unique();
            $table->foreignId('company_id')->constrained('companies')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos');
    }
};
