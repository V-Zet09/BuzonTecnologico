<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('buscar')) {
            $buscar = trim($request->buscar);

            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");

                if (is_numeric($buscar)) {
                    $q->orWhere('id', $buscar);
                }
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('estado')) {
            $estado = $request->estado === 'activo' ? true : false;
            $query->where('activo', $estado);
        }

        $users = $query->orderBy('id', 'desc')
            ->paginate(8)
            ->withQueryString();

        $stats = [
            'total' => User::count(),
            'activos' => User::where('activo', true)->count(),
            'admins' => User::where('role', 'admin')->count(),
            'alumnos' => User::where('role', 'alumno')->count(),
            'directores' => User::where('role', 'director')->count(),
            'subdirectores' => User::where('role', 'subdirector')->count(),
        ];

        return view('admin.usuarios', compact('users', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'alumno', 'director', 'subdirector'])],
            'activo' => ['required', 'boolean'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'activo' => $validated['activo'],
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Usuario creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'alumno', 'director', 'subdirector'])],
            'activo' => ['required', 'boolean'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'activo' => $validated['activo'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return back()->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Usuario eliminado correctamente');
    }
}