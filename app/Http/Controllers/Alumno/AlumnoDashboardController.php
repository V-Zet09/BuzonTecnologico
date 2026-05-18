<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\QuejaSugerencia;
use Illuminate\Support\Facades\Auth;

class AlumnoDashboardController extends Controller
{
    public function index()
    {
        $registros = QuejaSugerencia::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('alumno.dashboard', compact('registros'));
    }
}