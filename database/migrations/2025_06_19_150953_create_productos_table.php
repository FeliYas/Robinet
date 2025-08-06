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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('orden')->nullable();
            $table->string('path')->nullable();
            $table->string('titulo')->nullable();
            $table->string('codigo')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->string('manual')->nullable();
            $table->string('autocad')->nullable();
            $table->foreignId('subcategoria_id')->nullable()->constrained('subcategorias')->onDelete('cascade');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
