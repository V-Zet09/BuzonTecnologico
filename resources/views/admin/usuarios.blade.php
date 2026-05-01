@extends('layouts.app')

@section('content')

<div class="p-6">

    <h1 class="text-xl font-bold mb-4">Usuarios</h1>

    <!-- FORM CREAR -->
    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Correo" required>
        <input type="password" name="password" placeholder="Contraseña" required>

        <select name="rol">
            <option>Administrador</option>
            <option>Subdirector</option>
        </select>

        <select name="estado">
            <option>Activo</option>
            <option>Inactivo</option>
        </select>

        <button type="submit">Crear</button>
    </form>

    <hr class="my-6">

    <!-- LISTA -->
    @foreach($users as $user)

        <div class="border p-3 mb-3">

            <p>{{ $user->name }}</p>
            <p>{{ $user->email }}</p>

            <!-- EDITAR -->
            <form method="POST" action="{{ route('usuarios.update', $user->id) }}">
                @csrf
                @method('PUT')

                <input type="text" name="name" value="{{ $user->name }}">
                <input type="email" name="email" value="{{ $user->email }}">

                <select name="rol">
                    <option {{ $user->rol == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                    <option {{ $user->rol == 'Subdirector' ? 'selected' : '' }}>Subdirector</option>
                </select>

                <select name="estado">
                    <option {{ $user->estado == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option {{ $user->estado == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>

                <input type="password" name="password" placeholder="Nueva contraseña">

                <button type="submit">Actualizar</button>
            </form>

            <!-- ELIMINAR -->
            <form method="POST" action="{{ route('usuarios.destroy', $user->id) }}">
                @csrf
                @method('DELETE')

                <button type="submit">Eliminar</button>
            </form>

        </div>

    @endforeach

</div>

@endsection