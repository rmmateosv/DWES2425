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
        Schema::create('conciertos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('titulo')->nullable(false)->unique();
            $table->date('fecha')->nullable(false);
            $table->integer('aforo')->nullable(false);
            $table->float('precioEntrada')->nullable(false)->default(10);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conciertos');
    }
};
