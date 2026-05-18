@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Gestión de usuarios</h1>
            <p class="text-sm text-gray-500">Administra cuentas, roles y estado del sistema</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TARJETAS --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-400">Total</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-400">Activos</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['activos'] }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-400">Admins</p>
            <p class="text-2xl font-bold text-[#1F3A93] mt-1">{{ $stats['admins'] }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-400">Alumnos</p>
            <p class="text-2xl font-bold text-cyan-600 mt-1">{{ $stats['alumnos'] }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-400">Directores</p>
            <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['directores'] }}</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-400">Subdirectores</p>
            <p class="text-2xl font-bold text-purple-600 mt-1">{{ $stats['subdirectores'] }}</p>
        </div>
    </div>

    {{-- FORM CREAR --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Crear usuario</h2>

        <form method="POST" action="{{ route('admin.usuarios.store') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
            @csrf

            <input
                type="text"
                name="name"
                placeholder="Nombre"
                value="{{ old('name') }}"
                required
                class="border rounded-xl px-4 py-2.5 w-full"
            >

            <input
                type="email"
                name="email"
                placeholder="Correo"
                value="{{ old('email') }}"
                required
                class="border rounded-xl px-4 py-2.5 w-full"
            >

            <input
                type="password"
                name="password"
                placeholder="Contraseña"
                required
                class="border rounded-xl px-4 py-2.5 w-full"
            >

            <select name="role" required class="border rounded-xl px-4 py-2.5 w-full">
                <option value="">Seleccione un rol</option>
                <option value="admin" @selected(old('role') == 'admin')>Administrador</option>
                <option value="alumno" @selected(old('role') == 'alumno')>Alumno</option>
                <option value="director" @selected(old('role') == 'director')>Director</option>
                <option value="subdirector" @selected(old('role') == 'subdirector')>Subdirector</option>
            </select>

            <select name="activo" required class="border rounded-xl px-4 py-2.5 w-full">
                <option value="">Seleccione estado</option>
                <option value="1" @selected(old('activo') == '1')>Activo</option>
                <option value="0" @selected(old('activo') == '0')>Inactivo</option>
            </select>

            <div class="md:col-span-2 xl:col-span-5 flex justify-end">
                <button type="submit" class="bg-[#1F3A93] hover:bg-[#173075] text-white px-5 py-2.5 rounded-xl font-medium transition">
                    Crear usuario
                </button>
            </div>
        </form>
    </div>

    {{-- FILTROS --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Buscar y filtrar</h2>

        <form method="GET" action="{{ route('admin.usuarios.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input
                type="text"
                name="buscar"
                value="{{ request('buscar') }}"
                placeholder="Buscar por nombre, correo o ID"
                class="border rounded-xl px-4 py-2.5"
            >

            <select name="role" class="border rounded-xl px-4 py-2.5">
                <option value="">Todos los roles</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="alumno" {{ request('role') == 'alumno' ? 'selected' : '' }}>Alumno</option>
                <option value="director" {{ request('role') == 'director' ? 'selected' : '' }}>Director</option>
                <option value="subdirector" {{ request('role') == 'subdirector' ? 'selected' : '' }}>Subdirector</option>
            </select>

            <select name="estado" class="border rounded-xl px-4 py-2.5">
                <option value="">Todos los estados</option>
                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>

            <div class="flex gap-2">
                <button type="submit" class="bg-[#01696f] hover:bg-[#0c4e54] text-white px-4 py-2.5 rounded-xl font-medium transition w-full">
                    Filtrar
                </button>

                <a href="{{ route('admin.usuarios.index') }}" class="border border-gray-300 text-gray-700 px-4 py-2.5 rounded-xl text-center w-full hover:bg-gray-50 transition">
                    Limpiar
                </a>
            </div>
        </form>
    </div>

    {{-- LISTADO --}}
    <div class="space-y-4">
        @forelse($users as $user)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-6">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-[#e8eeff] text-[#1F3A93] flex items-center justify-center font-bold text-lg shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>

                            <div class="flex flex-wrap gap-2 mt-3">
                                <span class="text-xs px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                                    ID: {{ $user->id }}
                                </span>

                                <span class="text-xs px-3 py-1 rounded-full
                                    @if($user->role === 'admin') bg-[#e8eeff] text-[#1F3A93]
                                    @elseif($user->role === 'alumno') bg-cyan-100 text-cyan-700
                                    @elseif($user->role === 'director') bg-amber-100 text-amber-700
                                    @else bg-purple-100 text-purple-700
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>

                                <span class="text-xs px-3 py-1 rounded-full {{ $user->activo ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="w-full xl:max-w-3xl">
                        <form method="POST" action="{{ route('admin.usuarios.update', $user->id) }}" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @csrf
                            @method('PUT')

                            <input
                                type="text"
                                name="name"
                                value="{{ $user->name }}"
                                required
                                class="border rounded-xl px-4 py-2.5 w-full"
                            >

                            <input
                                type="email"
                                name="email"
                                value="{{ $user->email }}"
                                required
                                class="border rounded-xl px-4 py-2.5 w-full"
                            >

                            <select name="role" required class="border rounded-xl px-4 py-2.5 w-full">
                                <option value="admin" @selected($user->role == 'admin')>Administrador</option>
                                <option value="alumno" @selected($user->role == 'alumno')>Alumno</option>
                                <option value="director" @selected($user->role == 'director')>Director</option>
                                <option value="subdirector" @selected($user->role == 'subdirector')>Subdirector</option>
                            </select>

                            <select name="activo" required class="border rounded-xl px-4 py-2.5 w-full">
                                <option value="1" @selected((string) $user->activo === '1')>Activo</option>
                                <option value="0" @selected((string) $user->activo === '0')>Inactivo</option>
                            </select>

                            <input
                                type="password"
                                name="password"
                                placeholder="Nueva contraseña (opcional)"
                                class="border rounded-xl px-4 py-2.5 w-full md:col-span-2"
                            >

                            <div class="flex flex-wrap gap-3 md:col-span-2">
                                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 rounded-xl font-medium transition">
                                    Actualizar
                                </button>
                        </form>

                                <form method="POST" action="{{ route('admin.usuarios.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl font-medium transition"
                                        onclick="return confirm('¿Seguro que deseas eliminar este usuario?')"
                                    >
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-10 text-center text-gray-500">
                No se encontraron usuarios con los filtros aplicados.
            </div>
        @endforelse
    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection