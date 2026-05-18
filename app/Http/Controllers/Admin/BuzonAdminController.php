<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuejaSugerencia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BuzonAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = QuejaSugerencia::with('user')->orderBy('created_at', 'desc');

        if ($request->filled('busqueda')) {
            $b = $request->busqueda;
            $query->where(function ($q) use ($b) {
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

        return view('admin.buzon', compact('registros'));
    }

    public function updateEstado(Request $request, $id)
    {
        $validated = $request->validate([
            'estado' => ['required', Rule::in(['pendiente', 'en proceso', 'atendida'])],
        ]);

        $registro = QuejaSugerencia::findOrFail($id);
        $registro->update([
            'estado' => $validated['estado'],
        ]);

        return back()->with('success', 'Estado actualizado correctamente');
    }

    public function anular($id)
    {
        $registro = QuejaSugerencia::findOrFail($id);
        $registro->update([
            'anulado' => true,
        ]);

        return back()->with('success', 'Registro anulado correctamente');
    }

    public function show($id)
    {
        $registro = QuejaSugerencia::with('user')->findOrFail($id);

        return view('admin.buzon-detalle', compact('registro'));
    }
}