<?php

namespace App\Http\Controllers;

use App\Models\QuejaSugerencia;
use Illuminate\Http\Request;

class SubdirectorController extends Controller
{
    public function index(Request $request)
    {
        $query = QuejaSugerencia::orderBy('created_at', 'desc');

        if ($request->filled('busqueda')) {
            $b = $request->busqueda;
            $query->where(function($q) use ($b) {
                $q->where('folio', 'like', "%{$b}%")
                  ->orWhere('nombre', 'like', "%{$b}%")
                  ->orWhere('correo', 'like', "%{$b}%");
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'anulada') {
                $query->where('anulado', true);
            } else {
                $query->where('estado', $request->estado)
                      ->where('anulado', false);
            }
        }

        $registros = $query->get();

        $stats = [
            'total'      => QuejaSugerencia::count(),
            'pendientes' => QuejaSugerencia::where('estado', 'pendiente')->where('anulado', false)->count(),
            'atendidas'  => QuejaSugerencia::where('estado', 'atendida')->count(),
            'anuladas'   => QuejaSugerencia::where('anulado', true)->count(),
        ];

        return view('subdirector.dashboard', compact('registros', 'stats'));
    }

    public function show($id)
    {
        $registro = QuejaSugerencia::findOrFail($id);
        return view('subdirector.detalle', compact('registro'));
    }

    public function exportar()
    {
        $registros = QuejaSugerencia::orderBy('created_at', 'desc')->get();
        $filename  = 'quejas-sugerencias-subdirector-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($registros) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Folio','Tipo','Estado','Nombre','Correo','Teléfono',
                'Parte','Carrera','No. Control','Semestre','Grupo',
                'Turno','Aula','Procedencia','Queja','Sugerencia','Fecha'
            ]);

            foreach ($registros as $r) {
                fputcsv($file, [
                    $r->folio,
                    ucfirst($r->tipo),
                    $r->anulado ? 'Anulada' : ucfirst($r->estado),
                    $r->nombre,
                    $r->correo,
                    $r->telefono ?? '—',
                    ucfirst($r->parte),
                    $r->carrera ?? '—',
                    $r->no_control ?? '—',
                    $r->semestre ?? '—',
                    $r->grupo ?? '—',
                    $r->turno ?? '—',
                    $r->aula ?? '—',
                    $r->procedencia ?? '—',
                    $r->queja ?? '—',
                    $r->sugerencia ?? '—',
                    $r->fecha ? \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') : '—',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}