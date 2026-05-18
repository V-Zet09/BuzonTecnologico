<?php

namespace App\Http\Controllers;

use App\Models\QuejaSugerencia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ConfigController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $esAdmin = $user->role === 'admin';

        if ($esAdmin) {
            $usuarios = User::where('id', '!=', $user->id)->orderBy('name')->get();

            $stats = [
                'total_registros' => QuejaSugerencia::count(),
                'pendientes' => QuejaSugerencia::where('estado', 'pendiente')->where('anulado', false)->count(),
                'atendidas' => QuejaSugerencia::where('estado', 'atendida')->where('anulado', false)->count(),
                'usuarios_activos' => User::where('activo', true)->count(),
            ];
        } else {
            $usuarios = collect();

            $stats = [
                'total_registros' => QuejaSugerencia::where('user_id', $user->id)->count(),
                'pendientes' => QuejaSugerencia::where('user_id', $user->id)
                    ->where('estado', 'pendiente')
                    ->where('anulado', false)
                    ->count(),
                'atendidas' => QuejaSugerencia::where('user_id', $user->id)
                    ->where('estado', 'atendida')
                    ->where('anulado', false)
                    ->count(),
                'usuarios_activos' => 1,
            ];
        }

        $configuracion = [
            'notif_nueva_queja'     => (bool) ($user->notif_nueva_queja ?? false),
            'notif_atendida'        => (bool) ($user->notif_atendida ?? false),
            'notif_anulada'         => (bool) ($user->notif_anulada ?? false),
            'notif_reporte_semanal' => (bool) ($user->notif_reporte_semanal ?? false),
        ];

        $categorias = collect();

        return view('configuracion', compact(
            'user',
            'usuarios',
            'configuracion',
            'stats',
            'categorias',
            'esAdmin'
        ));
    }

    public function updatePerfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('configuracion')->with('success', 'Perfil actualizado correctamente.');
    }

    public function updateNotificaciones(Request $request)
    {
        $user = Auth::user();
        $user->notif_nueva_queja = $request->boolean('notif_nueva_queja');
        $user->notif_atendida = $request->boolean('notif_atendida');
        $user->notif_anulada = $request->boolean('notif_anulada');
        $user->notif_reporte_semanal = $request->boolean('notif_reporte_semanal');
        $user->save();

        return redirect()->route('configuracion')->with('success', 'Preferencias guardadas.');
    }

    public function toggleUsuario($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $usuario = User::findOrFail($id);
        $usuario->activo = !$usuario->activo;
        $usuario->save();

        $estado = $usuario->activo ? 'activado' : 'desactivado';

        return redirect()->route('configuracion')->with('success', "Usuario {$estado} correctamente.");
    }

    public function limpiar()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return redirect()->route('configuracion')->with('success', 'Función de limpieza pendiente de implementar.');
    }

    public function restablecer()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return redirect()->route('configuracion')->with('success', 'Función de restablecimiento pendiente de implementar.');
    }

    public function createUsuario()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.usuarios.create');
    }

    public function storeCategoria(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);

        return redirect()->route('configuracion')->with('success', 'Módulo de categorías pendiente de implementar.');
    }

    public function destroyCategoria($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return redirect()->route('configuracion')->with('success', 'Módulo de categorías pendiente de implementar.');
    }

    public function exportar(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        return redirect()->route('configuracion')->with('success', 'Módulo de exportación pendiente de implementar.');
    }
}