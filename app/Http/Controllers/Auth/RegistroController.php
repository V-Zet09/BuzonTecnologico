<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function create()
    {
        return view('auth.registro');
    }

    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'sexo'      => 'required|in:M,F,O',
            'telefono'  => 'required|digits:10',
            'matricula' => 'required|string|max:8|unique:usuarios,matricula',
            'correo'    => [
                'required',
                'email',
                'unique:usuarios,correo',
                // Dominio institucional obligatorio
                function ($attr, $value, $fail) {
                    if (!preg_match('/^[a-zA-Z0-9]+@ciudadaltamirano\.tecnm\.mx$/', $value)) {
                        $fail('El correo debe ser institucional (@ciudadaltamirano.tecnm.mx).');
                    }
                },
            ],
        ], [
            'nombre.required'    => 'El nombre es requerido.',
            'apellidos.required' => 'Los apellidos son requeridos.',
            'sexo.required'      => 'Selecciona un sexo.',
            'telefono.required'  => 'El teléfono es requerido.',
            'telefono.digits'    => 'El teléfono debe tener 10 dígitos.',
            'matricula.required' => 'La matrícula es requerida.',
            'matricula.unique'   => 'Esta matrícula ya está registrada.',
            'correo.required'    => 'El correo es requerido.',
            'correo.unique'      => 'Este correo ya está registrado.',
        ]);

        // Crear usuario — la matrícula es la contraseña inicial
        $usuario = Usuario::create([
            'nombre'    => $request->nombre,
            'apellidos' => $request->apellidos,
            'sexo'      => $request->sexo,
            'telefono'  => $request->telefono,
            'matricula' => $request->matricula,
            'correo'    => $request->correo,
            'password'  => Hash::make($request->matricula),
        ]);

        // Iniciar sesión automáticamente
        Auth::login($usuario);

        return redirect()->route('dashboard');
    }
}