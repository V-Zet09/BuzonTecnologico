<?php

namespace App\Http\Controllers;

use App\Models\QuejaSugerencia;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalRegistros = QuejaSugerencia::count();
        $pendientes = QuejaSugerencia::where('estado', 'pendiente')->where('anulado', false)->count();
        $enProceso = QuejaSugerencia::where('estado', 'en proceso')->where('anulado', false)->count();
        $atendidas = QuejaSugerencia::where('estado', 'atendida')->where('anulado', false)->count();
        $anuladas = QuejaSugerencia::where('anulado', true)->count();

        $totalUsuarios = User::count();
        $totalAlumnos = User::where('role', 'alumno')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalDirectores = User::where('role', 'director')->count();
        $totalSubdirectores = User::where('role', 'subdirector')->count();

        return view('admin.dashboard', compact(
            'totalRegistros',
            'pendientes',
            'enProceso',
            'atendidas',
            'anuladas',
            'totalUsuarios',
            'totalAlumnos',
            'totalAdmins',
            'totalDirectores',
            'totalSubdirectores'
        ));
    }
}