@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Panel de Administrador</h1>
        <p class="text-sm text-gray-500">Resumen general del sistema y accesos rápidos.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total registros</p>
            <h2 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalRegistros }}</h2>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Pendientes</p>
            <h2 class="text-3xl font-bold text-blue-600 mt-2">{{ $pendientes }}</h2>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm text-gray-500">En proceso</p>
            <h2 class="text-3xl font-bold text-yellow-600 mt-2">{{ $enProceso }}</h2>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Atendidas</p>
            <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $atendidas }}</h2>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Anuladas</p>
            <h2 class="text-3xl font-bold text-red-600 mt-2">{{ $anuladas }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Accesos rápidos</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.buzon.index') }}"
                   class="block border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition">
                    <h3 class="font-semibold text-gray-800 mb-1">Buzón administrativo</h3>
                    <p class="text-sm text-gray-500">Consultar, revisar, cambiar estado y anular registros.</p>
                </a>

                <a href="{{ route('admin.usuarios.index') }}"
                   class="block border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition">
                    <h3 class="font-semibold text-gray-800 mb-1">Gestión de usuarios</h3>
                    <p class="text-sm text-gray-500">Administrar cuentas, roles y acceso al sistema.</p>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Usuarios del sistema</h2>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Total usuarios</span>
                    <span class="font-semibold text-gray-800">{{ $totalUsuarios }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Alumnos</span>
                    <span class="font-semibold text-gray-800">{{ $totalAlumnos }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Admins</span>
                    <span class="font-semibold text-gray-800">{{ $totalAdmins }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Directores</span>
                    <span class="font-semibold text-gray-800">{{ $totalDirectores }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Subdirectores</span>
                    <span class="font-semibold text-gray-800">{{ $totalSubdirectores }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection