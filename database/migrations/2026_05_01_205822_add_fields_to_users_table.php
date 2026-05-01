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
    Schema::table('users', function (Blueprint $table) {

        $table->string('apellidos')->nullable();
        $table->enum('sexo', ['M', 'F', 'O'])->nullable();
        $table->string('telefono', 10)->nullable();
        $table->string('matricula', 8)->nullable()->unique();
        $table->string('role')->default('user'); // 👑 importante para admin

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
