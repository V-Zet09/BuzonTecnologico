<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Constants\UserRoles;

class RegistroController extends Controller
{
    public function create()
    {
        return view('auth.registro');
    }

    public function store(Request $request)
    {
        // VALIDACIÓN
        $request->validate([
            'nombre'    => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'sexo'      => 'required|in:M,F,O',
            'telefono'  => 'required|digits:10',
            'matricula' => 'required|string|max:8|unique:users,matricula',
            'email'     => [
                'required',
                'email',
                'unique:users,email',
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
            'email.required'     => 'El correo es requerido.',
            'email.unique'       => 'Este correo ya está registrado.',
        ]);

        // CREAR USUARIO (SIEMPRE ALUMNO)
        $user = User::create([
            'name'      => $request->nombre,
            'apellidos' => $request->apellidos,
            'sexo'      => $request->sexo,
            'telefono'  => $request->telefono,
            'matricula' => $request->matricula,
            'email'     => $request->email,
            'password'  => Hash::make($request->matricula),
            'role'      => UserRoles::ALUMNO,
        ]);

        // LOGIN AUTOMÁTICO + SEGURIDAD DE SESIÓN
        Auth::login($user);
        $request->session()->regenerate();

        // REDIRECCIÓN SEGURA
        return redirect()->route('dashboard');
    }
}