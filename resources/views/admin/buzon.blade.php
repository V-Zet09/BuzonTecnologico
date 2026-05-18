@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Buzón administrativo</h1>
            <p class="text-sm text-gray-500">Gestiona todas las quejas y sugerencias registradas.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
            Volver al panel
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.buzon.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6">
        <input
            type="text"
            name="busqueda"
            value="{{ request('busqueda') }}"
            placeholder="Buscar por folio, nombre o correo"
            class="border rounded-lg px-3 py-2 w-full"
        >

        <select name="tipo" class="border rounded-lg px-3 py-2 w-full">
            <option value="">Todos los tipos</option>
            <option value="queja" @selected(request('tipo') == 'queja')>Queja</option>
            <option value="sugerencia" @selected(request('tipo') == 'sugerencia')>Sugerencia</option>
        </select>

        <select name="estado" class="border rounded-lg px-3 py-2 w-full">
            <option value="">Todos los estados</option>
            <option value="pendiente" @selected(request('estado') == 'pendiente')>Pendiente</option>
            <option value="en proceso" @selected(request('estado') == 'en proceso')>En proceso</option>
            <option value="atendida" @selected(request('estado') == 'atendida')>Atendida</option>
            <option value="anulada" @selected(request('estado') == 'anulada')>Anulada</option>
        </select>

        <button type="submit" class="bg-[#01696f] text-white rounded-lg px-4 py-2 hover:bg-[#0c4e54] transition">
            Filtrar
        </button>
    </form>

    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Folio</th>
                    <th class="px-4 py-3 text-left">Tipo</th>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Correo</th>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($registros as $registro)
                    <tr class="{{ $registro->anulado ? 'bg-gray-50 opacity-70' : '' }}">
                        <td class="px-4 py-3 font-mono text-xs">{{ $registro->folio }}</td>
                        <td class="px-4 py-3 capitalize">{{ $registro->tipo }}</td>
                        <td class="px-4 py-3">{{ $registro->nombre }}</td>
                        <td class="px-4 py-3">{{ $registro->correo }}</td>
                        <td class="px-4 py-3">{{ optional($registro->fecha)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            @if($registro->anulado)
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-700">Anulada</span>
                            @elseif($registro->estado === 'pendiente')
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Pendiente</span>
                            @elseif($registro->estado === 'en proceso')
                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">En proceso</span>
                            @elseif($registro->estado === 'atendida')
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Atendida</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">{{ $registro->estado }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('admin.buzon.show', $registro->id) }}"
                                   class="text-blue-600 hover:underline text-xs">
                                    Ver detalle
                                </a>

                                @if(!$registro->anulado)
                                    <form method="POST" action="{{ route('admin.buzon.estado', $registro->id) }}" class="flex gap-2 items-center">
                                        @csrf
                                        @method('PATCH')

                                        <select name="estado" class="border rounded px-2 py-1 text-xs">
                                            <option value="pendiente" @selected($registro->estado === 'pendiente')>Pendiente</option>
                                            <option value="en proceso" @selected($registro->estado === 'en proceso')>En proceso</option>
                                            <option value="atendida" @selected($registro->estado === 'atendida')>Atendida</option>
                                        </select>

                                        <button type="submit" class="text-xs bg-[#01696f] text-white px-2 py-1 rounded hover:bg-[#0c4e54]">
                                            Guardar
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('admin.buzon.anular', $registro->id) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                onclick="return confirm('¿Seguro que deseas anular este registro?')"
                                                class="text-xs bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                            Anular
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            No hay registros para mostrar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection