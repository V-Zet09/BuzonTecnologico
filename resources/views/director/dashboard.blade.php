@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen bg-gray-50">

  {{-- TOPBAR --}}
  <div class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
    <div>
      <h1 class="text-base font-semibold text-gray-800">Panel del Director</h1>
      <p class="text-xs text-gray-400">Solo lectura · TecNM-CA-PO-004-01</p>
    </div>
    <span class="text-xs text-gray-400">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
  </div>

  <div class="flex-1 p-6">

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-4 text-center">
        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Total registros</p>
      </div>
      <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-4 text-center">
        <p class="text-2xl font-bold text-blue-500">{{ $stats['pendientes'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Pendientes</p>
      </div>
      <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-4 text-center">
        <p class="text-2xl font-bold text-emerald-500">{{ $stats['atendidas'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Atendidas</p>
      </div>
      <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-4 text-center">
        <p class="text-2xl font-bold text-gray-400">{{ $stats['anuladas'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">Anuladas</p>
      </div>
    </div>
{{-- BUSCADOR Y FILTROS --}}
<form method="GET" action="{{ route('director.dashboard') }}" class="flex flex-wrap gap-2 mb-4">
    <input type="text" name="busqueda" value="{{ request('busqueda') }}"
        placeholder="Buscar por folio, nombre o correo..."
        class="flex-1 min-w-48 border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 focus:border-[#01696f] transition"/>

    <select name="tipo" class="border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition">
        <option value="">Todos los tipos</option>
        <option value="queja"      {{ request('tipo') === 'queja'      ? 'selected' : '' }}>Quejas</option>
        <option value="sugerencia" {{ request('tipo') === 'sugerencia' ? 'selected' : '' }}>Sugerencias</option>
    </select>

    <select name="estado" class="border border-gray-200 rounded-xl px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition">
        <option value="">Todos los estados</option>
        <option value="pendiente"  {{ request('estado') === 'pendiente'  ? 'selected' : '' }}>Pendientes</option>
        <option value="en proceso" {{ request('estado') === 'en proceso' ? 'selected' : '' }}>En proceso</option>
        <option value="atendida"   {{ request('estado') === 'atendida'   ? 'selected' : '' }}>Atendidas</option>
        <option value="anulada"    {{ request('estado') === 'anulada'    ? 'selected' : '' }}>Anuladas</option>
    </select>

    <button type="submit"
        class="bg-[#01696f] hover:bg-[#0c4e54] text-white px-4 py-2 rounded-xl text-sm font-medium transition">
        🔍 Buscar
    </button>

    @if(request()->hasAny(['busqueda','tipo','estado']))
    <a href="{{ route('director.dashboard') }}"
        class="border border-gray-200 text-gray-600 hover:bg-gray-50 px-4 py-2 rounded-xl text-sm font-medium transition">
        ✕ Limpiar
    </a>
    @endif
</form>
    {{-- EXPORTAR --}}
    <div class="flex justify-end mb-4">
      <a href="{{ route('director.exportar') }}"
         class="flex items-center gap-2 bg-[#01696f] hover:bg-[#0c4e54] text-white px-4 py-2 rounded-xl text-sm font-medium transition">
        📥 Exportar Excel
      </a>
    </div>

    {{-- TABLA --}}
    <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
          <tr>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Folio</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipo</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Solicitante</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acción</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
          @forelse($registros as $r)
          <tr class="hover:bg-gray-50 transition {{ $r->anulado ? 'opacity-50' : '' }}">
            <td class="px-5 py-3 font-mono text-xs text-gray-500">{{ $r->folio }}</td>
            <td class="px-5 py-3">
              <span class="text-xs px-2 py-0.5 rounded-full font-medium
                {{ $r->tipo === 'queja' ? 'bg-red-50 text-red-600' : 'bg-teal-50 text-teal-700' }}">
                {{ ucfirst($r->tipo) }}
              </span>
            </td>
            <td class="px-5 py-3 text-gray-700">{{ $r->nombre }}</td>
            <td class="px-5 py-3">
              @if($r->anulado)
                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 font-medium">Anulada</span>
              @elseif($r->estado === 'atendida')
                <span class="text-xs px-2 py-0.5 rounded-full bg-green-50 text-green-600 font-medium">Atendida</span>
              @elseif($r->estado === 'en proceso')
                <span class="text-xs px-2 py-0.5 rounded-full bg-yellow-50 text-yellow-600 font-medium">En proceso</span>
              @else
                <span class="text-xs px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 font-medium">Pendiente</span>
              @endif
            </td>
            <td class="px-5 py-3 text-xs text-gray-400 tabular-nums">
              {{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}
            </td>
            <td class="px-5 py-3">
              <a href="{{ route('director.detalle', $r->id) }}"
                 class="text-xs text-[#01696f] hover:underline font-medium">
                Ver detalle
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-5 py-16 text-center text-gray-400 text-sm">
              No hay registros aún.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</div>
@endsection