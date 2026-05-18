@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen bg-gray-50">

  {{-- TOPBAR --}}
  <div class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
    <div>
      <h1 class="text-base font-semibold text-gray-800">Detalle · {{ $registro->folio }}</h1>
      <p class="text-xs text-gray-400">Solo lectura · TecNM-CA-PO-004-01</p>
    </div>
    <span class="text-xs text-gray-400">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
  </div>

  <div class="flex-1 p-6">
    <div class="max-w-3xl mx-auto space-y-4">

      {{-- BOTONES --}}
      <div class="flex items-center gap-2">
        <a href="{{ route('subdirector.dashboard') }}"
           class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 px-3 py-2 rounded-lg hover:bg-white border border-transparent hover:border-gray-200 transition">
          ← Volver
        </a>
        <button onclick="window.print()"
           class="flex items-center gap-1.5 text-sm text-gray-600 px-3 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 transition ml-auto">
          🖨️ Imprimir acuse
        </button>
      </div>

      {{-- CABECERA --}}
      <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
        <div class="bg-[#01696f] px-6 py-5 flex items-start justify-between gap-4">
          <div>
            <p class="text-white/70 text-xs mb-1 uppercase tracking-widest">Acuse de recibo · TecNM-CA-PO-004-01</p>
            <h2 class="text-white text-lg font-semibold">Queja y/o sugerencia registrada</h2>
          </div>
          <div class="text-right shrink-0">
            <p class="text-white/60 text-xs mb-0.5">Folio</p>
            <p class="text-white font-bold font-mono text-xl tracking-widest">{{ $registro->folio }}</p>
          </div>
        </div>

        <div class="p-6 space-y-5">

          {{-- ESTADO --}}
          <div class="flex items-center gap-3">
            @if($registro->anulado)
              <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-gray-100 text-gray-500">
                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>Anulada
              </span>
            @elseif($registro->estado === 'atendida')
              <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-green-100 text-green-700">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Atendida
              </span>
            @else
              <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-blue-100 text-blue-700">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Pendiente de atención
              </span>
            @endif
            <span class="text-xs text-gray-400">
              Enviada el {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}
            </span>
          </div>

          {{-- SOLICITANTE Y DATOS --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
              <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Solicitante</p>
              <p class="text-sm font-semibold text-gray-800">{{ $registro->nombre }}</p>
              <p class="text-xs text-gray-500 mt-0.5">{{ $registro->correo }}</p>
              @if($registro->telefono)
                <p class="text-xs text-gray-500">Tel: {{ $registro->telefono }}</p>
              @endif
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
              <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Datos académicos</p>
              @if($registro->parte === 'alumno')
                <p class="text-sm text-gray-700">Alumno · {{ $registro->carrera }}</p>
                <p class="text-xs text-gray-500 mt-0.5">
                  Sem. {{ $registro->semestre }} · Grupo {{ $registro->grupo }} · {{ $registro->turno }} · Aula {{ $registro->aula }}
                </p>
                <p class="text-xs text-gray-500">No. Control: {{ $registro->no_control }}</p>
              @else
                <p class="text-sm text-gray-700">Parte interesada</p>
                <p class="text-xs text-gray-500 mt-0.5">{{ $registro->procedencia ?? '—' }}</p>
              @endif
            </div>
          </div>

          {{-- QUEJA --}}
          @if($registro->queja)
          <div>
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">(12) Queja</p>
            <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-xl p-4 border border-gray-100">
              {{ $registro->queja }}
            </p>
          </div>
          @endif

          {{-- SUGERENCIA --}}
          @if($registro->sugerencia)
          <div>
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">(13) Sugerencia</p>
            <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-xl p-4 border border-gray-100">
              {{ $registro->sugerencia }}
            </p>
          </div>
          @endif

          {{-- FOOTER --}}
          <div class="flex items-center justify-between text-xs text-gray-400 pt-2 border-t border-gray-100">
            <span>(14) Fecha: {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</span>
            <span>Instituto Tecnológico · TecNM</span>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection