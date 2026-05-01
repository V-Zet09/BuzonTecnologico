<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // LISTAR
    public function index()
    {
        $users = User::all();
        return view('admin.usuarios', compact('users'));
    }

    // CREAR
    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'estado' => $request->estado,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Usuario creado');
    }

    // ACTUALIZAR
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'estado' => $request->estado,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Usuario actualizado');
    }

    // ELIMINAR
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'Usuario eliminado');
    }
}