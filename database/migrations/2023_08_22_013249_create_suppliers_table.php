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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->string('identification', 20);
            $table->string('phone', 50);
            $table->string('email', 50);
            $table->string('address', 50);
            $table->string('city', 50);
            $table->string('department', 50);
            $table->integer('credit_amount');
            $table->string('description', 150);
           $table->boolean('state')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
