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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('orden')->nullable();
            $table->string('portada')->nullable();
            $table->string('path')->nullable();
            $table->string('icono')->nullable();
            $table->string('titulo')->nullable();
            $table->string('lugar')->nullable();
            $table->mediumText('descripcion')->nullable();
            $table->boolean('destacado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
