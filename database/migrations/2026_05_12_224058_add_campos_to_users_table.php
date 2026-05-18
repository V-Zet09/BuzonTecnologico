<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('activo')->default(true);
            $table->boolean('notif_nueva_queja')->default(true);
            $table->boolean('notif_atendida')->default(true);
            $table->boolean('notif_anulada')->default(false);
            $table->boolean('notif_reporte_semanal')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'activo',
                'notif_nueva_queja',
                'notif_atendida',
                'notif_anulada',
                'notif_reporte_semanal',
            ]);
        });
    }
};