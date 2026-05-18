<?php

namespace App\Http\Controllers;

use App\Models\QuejaSugerencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuzonController extends Controller
{
    // Lista del usuario autenticado
    public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') {
        $registros = QuejaSugerencia::orderBy('created_at', 'desc')->get();
    } else {
        $registros = QuejaSugerencia::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    return response()->json($registros);
}

    // Guardar nueva queja/sugerencia
    public function store(Request $request)
    {
        $request->validate([
            'tipo'    => 'required|in:queja,sugerencia',
            'nombre'  => 'required|string|max:255',
            'correo'  => 'required|email',
            'parte'   => 'required|in:alumno,otro',
            'fecha'   => 'required|date',
        ]);

        $registro = QuejaSugerencia::create([
            'user_id'     => Auth::id(),
            'folio'       => QuejaSugerencia::generarFolio(),
            'tipo'        => $request->tipo,
            'nombre'      => $request->nombre,
            'correo'      => $request->correo,
            'telefono'    => $request->telefono,
            'parte'       => $request->parte,
            'no_control'  => $request->no_control,
            'carrera'     => $request->carrera,
            'semestre'    => $request->semestre,
            'grupo'       => $request->grupo,
            'turno'       => $request->turno,
            'aula'        => $request->aula,
            'procedencia' => $request->procedencia,
            'queja'       => $request->queja,
            'sugerencia'  => $request->sugerencia,
            'fecha'       => $request->fecha,
        ]);

        return response()->json($registro, 201);
    }

    // Editar
    public function update(Request $request, $id)
    {
        $registro = QuejaSugerencia::where('user_id', Auth::id())
            ->findOrFail($id);

        $registro->update($request->only([
            'tipo', 'nombre', 'correo', 'telefono', 'parte',
            'no_control', 'carrera', 'semestre', 'grupo', 'turno',
            'aula', 'procedencia', 'queja', 'sugerencia', 'fecha'
        ]));

        return response()->json($registro);
    }

    // Anular
    public function anular($id)
    {
        $registro = QuejaSugerencia::where('user_id', Auth::id())
            ->findOrFail($id);

        $registro->update(['anulado' => true]);

        return response()->json(['message' => 'Anulado correctamente']);
    }

    // Consultar por folio
    public function porFolio($folio)
    {
        $registro = QuejaSugerencia::where('folio', strtoupper($folio))->first();

        if (!$registro) {
            return response()->json(['error' => 'No encontrado'], 404);
        }

        return response()->json($registro);
    }
    // Lista COMPLETA para roles con permiso de ver todo (admin, director)
public function indexTodos(Request $request)
{
    $query = QuejaSugerencia::orderBy('created_at', 'desc');

    // Filtro opcional por búsqueda (folio, nombre, correo)
    if ($request->filled('busqueda')) {
        $b = $request->busqueda;
        $query->where(function($q) use ($b) {
            $q->where('folio',  'like', "%{$b}%")
              ->orWhere('nombre','like', "%{$b}%")
              ->orWhere('correo','like', "%{$b}%");
        });
    }

    // Filtro opcional por tipo (queja/sugerencia)
    if ($request->filled('tipo')) {
        $query->where('tipo', $request->tipo);
    }

    // Filtro opcional por estado (pendiente/en proceso/atendida)
    if ($request->filled('estado')) {
        if ($request->estado === 'anulada') {
            $query->where('anulado', true);
        } else {
            $query->where('estado', $request->estado)->where('anulado', false);
        }
    }

    return response()->json($query->get());
}
}