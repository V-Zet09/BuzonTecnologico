<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\QuejaSugerencia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalRegistros = QuejaSugerencia::where('user_id', $user->id)->count();
        $pendientes = QuejaSugerencia::where('user_id', $user->id)
            ->where('estado', 'pendiente')
            ->where('anulado', false)
            ->count();

        $atendidas = QuejaSugerencia::where('user_id', $user->id)
            ->where('estado', 'atendida')
            ->where('anulado', false)
            ->count();

        $sugerencias = QuejaSugerencia::where('user_id', $user->id)
            ->where('tipo', 'sugerencia')
            ->where('anulado', false)
            ->count();

        $anuladas = QuejaSugerencia::where('user_id', $user->id)
            ->where('anulado', true)
            ->count();

        $ultimosRegistros = QuejaSugerencia::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('profile', compact(
            'user',
            'totalRegistros',
            'pendientes',
            'atendidas',
            'sugerencias',
            'anuladas',
            'ultimosRegistros'
        ));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}