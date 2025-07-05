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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->string('identification_card', 20);
            $table->string('phone', 15);
            $table->string('email', 50);
            $table->string('address', 50);
            $table->string('department', 50);
            $table->string('city', 50);
            $table->string('logo', 150)->nullable();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('restrict')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
