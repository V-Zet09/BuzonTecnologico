@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detalle del registro</h1>
            <p class="text-sm text-gray-500">Consulta la información completa de la queja o sugerencia.</p>
        </div>

        <a href="{{ route('admin.buzon.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
            Volver al buzón
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información principal -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="text-xs font-mono px-3 py-1 rounded-full bg-gray-100 text-gray-700">
                        {{ $registro->folio }}
                    </span>

                    <span class="text-xs px-3 py-1 rounded-full capitalize
                        {{ $registro->tipo === 'queja' ? 'bg-red-100 text-red-700' : 'bg-teal-100 text-teal-700' }}">
                        {{ $registro->tipo }}
                    </span>

                    @if($registro->anulado)
                        <span class="text-xs px-3 py-1 rounded-full bg-gray-200 text-gray-700">
                            Anulada
                        </span>
                    @elseif($registro->estado === 'pendiente')
                        <span class="text-xs px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                            Pendiente
                        </span>
                    @elseif($registro->estado === 'en proceso')
                        <span class="text-xs px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">
                            En proceso
                        </span>
                    @elseif($registro->estado === 'atendida')
                        <span class="text-xs px-3 py-1 rounded-full bg-green-100 text-green-700">
                            Atendida
                        </span>
                    @endif
                </div>

                <h2 class="text-lg font-semibold text-gray-800 mb-4">Datos del solicitante</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Nombre</p>
                        <p class="font-medium text-gray-800">{{ $registro->nombre ?: '—' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Correo</p>
                        <p class="font-medium text-gray-800">{{ $registro->correo ?: '—' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Teléfono</p>
                        <p class="font-medium text-gray-800">{{ $registro->telefono ?: '—' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Fecha</p>
                        <p class="font-medium text-gray-800">{{ optional($registro->fecha)->format('d/m/Y') ?: '—' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Parte interesada</p>
                        <p class="font-medium text-gray-800 capitalize">{{ $registro->parte ?: '—' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Usuario del sistema</p>
                        <p class="font-medium text-gray-800">
                            {{ optional($registro->user)->name ?: 'No vinculado' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Datos adicionales</h2>

                @if($registro->parte === 'alumno')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">No. de control</p>
                            <p class="font-medium text-gray-800">{{ $registro->no_control ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Carrera</p>
                            <p class="font-medium text-gray-800">{{ $registro->carrera ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Semestre</p>
                            <p class="font-medium text-gray-800">{{ $registro->semestre ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Grupo</p>
                            <p class="font-medium text-gray-800">{{ $registro->grupo ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Turno</p>
                            <p class="font-medium text-gray-800">{{ $registro->turno ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="text-gray-500">Aula</p>
                            <p class="font-medium text-gray-800">{{ $registro->aula ?: '—' }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-sm">
                        <p class="text-gray-500">Procedencia</p>
                        <p class="font-medium text-gray-800">{{ $registro->procedencia ?: '—' }}</p>
                    </div>
                @endif
            </div>

            @if($registro->queja)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Queja</h2>
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $registro->queja }}</p>
                </div>
            @endif

            @if($registro->sugerencia)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Sugerencia</h2>
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $registro->sugerencia }}</p>
                </div>
            @endif
        </div>

        <!-- Acciones -->
        <div class="space-y-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Acciones administrativas</h2>

                @if(!$registro->anulado)
                    <form method="POST" action="{{ route('admin.buzon.estado', $registro->id) }}" class="space-y-3 mb-4">
                        @csrf
                        @method('PATCH')

                        <label class="block text-sm font-medium text-gray-700">Cambiar estado</label>

                        <select name="estado" class="border rounded-lg px-3 py-2 w-full">
                            <option value="pendiente" @selected($registro->estado === 'pendiente')>Pendiente</option>
                            <option value="en proceso" @selected($registro->estado === 'en proceso')>En proceso</option>
                            <option value="atendida" @selected($registro->estado === 'atendida')>Atendida</option>
                        </select>

                        <button type="submit"
                                class="w-full bg-[#01696f] text-white px-4 py-2 rounded-lg hover:bg-[#0c4e54] transition">
                            Guardar estado
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.buzon.anular', $registro->id) }}">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                onclick="return confirm('¿Seguro que deseas anular este registro?')"
                                class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                            Anular registro
                        </button>
                    </form>
                @else
                    <div class="p-3 rounded-lg bg-gray-100 text-gray-700 text-sm">
                        Este registro ya fue anulado.
                    </div>
                @endif
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Resumen</h2>

                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-500">Folio</p>
                        <p class="font-medium text-gray-800">{{ $registro->folio }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Tipo</p>
                        <p class="font-medium text-gray-800 capitalize">{{ $registro->tipo }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Estado actual</p>
                        <p class="font-medium text-gray-800">{{ $registro->anulado ? 'Anulada' : ucfirst($registro->estado) }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Creado</p>
                        <p class="font-medium text-gray-800">
                            {{ optional($registro->created_at)->format('d/m/Y H:i') ?: '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Última actualización</p>
                        <p class="font-medium text-gray-800">
                            {{ optional($registro->updated_at)->format('d/m/Y H:i') ?: '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection