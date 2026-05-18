<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuejaSugerencia extends Model
{
    protected $table = 'quejas_sugerencias';

    protected $fillable = [
        'user_id', 'folio', 'tipo', 'nombre', 'correo', 'telefono',
        'parte', 'no_control', 'carrera', 'semestre', 'grupo',
        'turno', 'aula', 'procedencia', 'queja', 'sugerencia',
        'fecha', 'estado', 'anulado'
    ];

    protected $casts = [
        'anulado' => 'boolean',
        'fecha'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Genera folio automático: BQS-2026-XXXX
    public static function generarFolio(): string
    {
        $anio = date('Y');
        $ultimo = self::whereYear('created_at', $anio)->count() + 1;
        return 'BQS-' . $anio . '-' . str_pad($ultimo, 4, '0', STR_PAD_LEFT);
    }
}