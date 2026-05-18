<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quejas_sugerencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('folio')->unique();
            $table->enum('tipo', ['queja', 'sugerencia']);

            // Solicitante
            $table->string('nombre');
            $table->string('correo');
            $table->string('telefono', 10)->nullable();

            // Parte interesada
            $table->enum('parte', ['alumno', 'otro']);
            $table->string('no_control', 8)->nullable();
            $table->string('carrera')->nullable();
            $table->string('semestre', 2)->nullable();
            $table->string('grupo', 5)->nullable();
            $table->enum('turno', ['Matutino', 'Vespertino'])->nullable();
            $table->string('aula', 10)->nullable();
            $table->string('procedencia')->nullable();

            // Descripción
            $table->text('queja')->nullable();
            $table->text('sugerencia')->nullable();

            $table->date('fecha');
            $table->enum('estado', ['pendiente', 'en proceso', 'atendida'])->default('pendiente');
            $table->boolean('anulado')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quejas_sugerencias');
    }
};