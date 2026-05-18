@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f5f7fb] p-6">

    <div class="bg-[#1F3A93] rounded-3xl shadow-lg overflow-hidden">
        <div class="h-36 bg-gradient-to-r from-[#1F3A93] to-[#2952cc] relative">
            <div class="absolute -bottom-16 left-8">
                <div class="w-32 h-32 rounded-3xl border-4 border-white bg-white shadow-xl flex items-center justify-center">
                    <span class="text-5xl font-bold text-[#1F3A93]">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="pt-20 pb-8 px-8 bg-white">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        {{ $user->name }}
                    </h1>

                    <p class="text-[#1F3A93] font-medium mt-1">
                        {{ $user->email }}
                    </p>

                    <p class="text-gray-500 mt-2">
                        Rol: <span class="font-medium capitalize">{{ $user->role }}</span>
                    </p>

                    <p class="text-gray-500 mt-3 max-w-2xl">
                        Bienvenido al sistema institucional de buzón de quejas y sugerencias.
                        Desde aquí puedes consultar tu información personal y el resumen de tus registros.
                    </p>
                </div>

                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('profile.edit') }}"
                        class="bg-[#1F3A93] hover:bg-[#173075] text-white px-6 py-3 rounded-2xl font-medium transition">
                        Editar perfil
                    </a>

                    <a href="{{ route('configuracion') }}"
                        class="border border-[#1F3A93] text-[#1F3A93] hover:bg-[#1F3A93] hover:text-white px-6 py-3 rounded-2xl font-medium transition">
                        Configuración
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Registros realizados</p>
                    <h2 class="text-4xl font-bold text-[#1F3A93] mt-2">{{ $totalRegistros }}</h2>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-[#e8eeff] flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-[#1F3A93]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Pendientes</p>
                    <h2 class="text-4xl font-bold text-yellow-500 mt-2">{{ $pendientes }}</h2>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center">⏳</div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Atendidas</p>
                    <h2 class="text-4xl font-bold text-green-500 mt-2">{{ $atendidas }}</h2>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center">✔</div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Sugerencias</p>
                    <h2 class="text-4xl font-bold text-cyan-500 mt-2">{{ $sugerencias }}</h2>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-cyan-100 flex items-center justify-center">💡</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Información del usuario</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm text-gray-500">Nombre completo</label>
                    <div class="mt-2 bg-gray-50 border rounded-2xl px-4 py-3">{{ $user->name }}</div>
                </div>

                <div>
                    <label class="text-sm text-gray-500">Correo institucional</label>
                    <div class="mt-2 bg-gray-50 border rounded-2xl px-4 py-3">{{ $user->email }}</div>
                </div>

                <div>
                    <label class="text-sm text-gray-500">Rol</label>
                    <div class="mt-2 bg-gray-50 border rounded-2xl px-4 py-3 capitalize">{{ $user->role }}</div>
                </div>

                <div>
                    <label class="text-sm text-gray-500">Fecha de registro</label>
                    <div class="mt-2 bg-gray-50 border rounded-2xl px-4 py-3">
                        {{ optional($user->created_at)->format('d/m/Y H:i') ?: '—' }}
                    </div>
                </div>

                <div>
                    <label class="text-sm text-gray-500">Registros anulados</label>
                    <div class="mt-2 bg-gray-50 border rounded-2xl px-4 py-3">{{ $anuladas }}</div>
                </div>

                <div>
                    <label class="text-sm text-gray-500">ID de usuario</label>
                    <div class="mt-2 bg-gray-50 border rounded-2xl px-4 py-3">{{ $user->id }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Últimos registros</h3>

            <div class="space-y-5">
                @forelse($ultimosRegistros as $registro)
                    <div class="flex gap-4">
                        <div class="w-3 h-3 mt-2 rounded-full
                            {{ $registro->anulado ? 'bg-gray-400' : ($registro->estado === 'atendida' ? 'bg-green-500' : ($registro->estado === 'pendiente' ? 'bg-yellow-500' : 'bg-blue-500')) }}">
                        </div>

                        <div>
                            <p class="font-medium text-gray-700">
                                {{ $registro->folio }} · {{ ucfirst($registro->tipo) }}
                            </p>

                            <span class="text-sm text-gray-400">
                                {{ $registro->anulado ? 'Anulada' : ucfirst($registro->estado) }}
                                · {{ optional($registro->created_at)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">
                        Aún no tienes registros en el buzón.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection