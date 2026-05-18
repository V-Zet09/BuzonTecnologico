@extends('layouts.app')

@section('content')

<div class="flex flex-col min-h-screen bg-gray-50">

  {{-- TOPBAR --}}
  <div class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
    <div>
      <h1 id="page-title" class="text-base font-semibold text-gray-800">Mis quejas y sugerencias</h1>
      <p class="text-xs text-gray-400">TecNM-CA-PO-004-01</p>
    </div>
    <span class="text-xs text-gray-400">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
  </div>

  {{-- PANTALLAS --}}
  <div class="flex-1 p-6">

    {{-- ===== PANTALLA: BANDEJA ===== --}}
    <div id="screen-bandeja" class="screen active">

      {{-- Stats --}}
      <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-4 text-center">
          <p class="text-2xl font-bold text-gray-800">{{ $registros->count() }}</p>
          <p class="text-xs text-gray-400 mt-0.5">Total enviadas</p>
        </div>
        <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-4 text-center">
          <p class="text-2xl font-bold text-blue-500">{{ $registros->where('estado','pendiente')->where('anulado',false)->count() }}</p>
          <p class="text-xs text-gray-400 mt-0.5">Pendientes</p>
        </div>
        <div class="bg-white rounded-2xl border border-black/5 shadow-sm p-4 text-center">
          <p class="text-2xl font-bold text-emerald-500">{{ $registros->where('estado','atendida')->count() }}</p>
          <p class="text-xs text-gray-400 mt-0.5">Atendidas</p>
        </div>
      </div>

      {{-- Filtros --}}
      <div class="flex flex-wrap gap-2 mb-4">
        <button onclick="filterBandeja('todas',this)"   class="filter-btn active-filter px-3 py-1.5 rounded-full text-xs font-medium transition-colors">Todas</button>
        <button onclick="filterBandeja('queja',this)"   class="filter-btn px-3 py-1.5 rounded-full text-xs font-medium bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">Quejas</button>
        <button onclick="filterBandeja('sugerencia',this)" class="filter-btn px-3 py-1.5 rounded-full text-xs font-medium bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">Sugerencias</button>
        <button onclick="filterBandeja('pendiente',this)"  class="filter-btn px-3 py-1.5 rounded-full text-xs font-medium bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">Pendientes</button>
        <button onclick="filterBandeja('atendida',this)"   class="filter-btn px-3 py-1.5 rounded-full text-xs font-medium bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">Atendidas</button>

        <button onclick="goTo('redactar')" class="ml-auto flex items-center gap-1.5 bg-[#01696f] hover:bg-[#0c4e54] text-white px-4 py-1.5 rounded-full text-xs font-medium transition-colors">
          <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Nueva
        </button>
      </div>

      {{-- Lista --}}
      <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
        <div id="lista-bandeja" class="divide-y divide-gray-50"></div>
        <div id="bandeja-vacia" class="hidden flex-col items-center justify-center py-20 text-center">
          <svg class="w-12 h-12 text-gray-200 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 12h-6l-2 3h-4l-2-3H2"/><path d="M5.45 5.11L2 12v6a2 2 0 002 2h16a2 2 0 002-2v-6l-3.45-6.89A2 2 0 0016.76 4H7.24a2 2 0 00-1.79 1.11z"/></svg>
          <p class="text-sm font-medium text-gray-400">No tienes registros aún</p>
          <button onclick="goTo('redactar')" class="mt-3 text-xs text-[#01696f] hover:underline font-medium">+ Enviar nueva queja o sugerencia</button>
        </div>
      </div>
    </div>

    {{-- ===== PANTALLA: REDACTAR ===== --}}
    <div id="screen-redactar" class="screen hidden">
      <div class="max-w-3xl w-full mx-auto space-y-4">
        <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
              <h2 id="form-title" class="text-base font-semibold text-gray-800">Nueva queja / sugerencia</h2>
              <p class="text-xs text-gray-400 mt-0.5">Formato TecNM-CA-PO-004-01 · Revisión O</p>
            </div>
            <span id="form-folio-badge" class="hidden text-xs font-mono bg-[#cedcd8] text-[#01696f] px-3 py-1 rounded-full font-semibold"></span>
          </div>
          <form id="buzon-form" onsubmit="handleSubmit(event)" class="p-6 space-y-6" novalidate>

            {{-- Tipo --}}
            <fieldset>
              <legend class="text-sm font-semibold text-gray-700 mb-2">Tipo de reporte <span class="text-red-500">*</span></legend>
              <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" name="tipo" value="queja" class="w-4 h-4 accent-[#01696f]" required/>
                  <span class="text-sm text-gray-700">Queja</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" name="tipo" value="sugerencia" class="w-4 h-4 accent-[#01696f]"/>
                  <span class="text-sm text-gray-700">Sugerencia</span>
                </label>
              </div>
              <p id="err-tipo" class="hidden text-xs text-red-500 mt-1">Selecciona el tipo de reporte.</p>
            </fieldset>

            {{-- Solicitante --}}
            <div class="border-t border-gray-100 pt-4">
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4">Datos del solicitante (confidenciales)</p>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                  <label for="f-nombre" class="block text-sm font-medium text-gray-700 mb-1">(1) Nombre completo <span class="text-red-500">*</span></label>
                  <input type="text" id="f-nombre" placeholder="Nombre del solicitante" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 focus:border-[#01696f] transition"/>
                  <p id="err-nombre" class="hidden text-xs text-red-500 mt-1">El nombre es obligatorio.</p>
                </div>
                <div>
                  <label for="f-correo" class="block text-sm font-medium text-gray-700 mb-1">(2) Correo electrónico <span class="text-red-500">*</span></label>
                  <input type="email" id="f-correo" placeholder="correo@institucion.edu.mx" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 focus:border-[#01696f] transition"/>
                  <p id="err-correo" class="hidden text-xs text-red-500 mt-1">El correo es obligatorio.</p>
                </div>
                <div>
                  <label for="f-tel" class="block text-sm font-medium text-gray-700 mb-1">(3) Teléfono</label>
                  <input type="tel" id="f-tel" placeholder="10 dígitos" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 focus:border-[#01696f] transition"/>
                </div>
              </div>
            </div>

            {{-- Parte interesada --}}
            <div class="border-t border-gray-100 pt-4">
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-3">(4) Parte interesada <span class="text-red-500">*</span></p>
              <div class="flex gap-4 mb-4">
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" name="parte" value="alumno" class="w-4 h-4 accent-[#01696f]" onchange="toggleParte()"/>
                  <span class="text-sm text-gray-700">Alumno</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" name="parte" value="otro" class="w-4 h-4 accent-[#01696f]" onchange="toggleParte()"/>
                  <span class="text-sm text-gray-700">Parte interesada</span>
                </label>
              </div>
              <p id="err-parte" class="hidden text-xs text-red-500 -mt-2 mb-2">Selecciona el tipo de parte.</p>

              <div id="campos-alumno" class="hidden grid grid-cols-2 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                  <label for="f-control" class="block text-sm font-medium text-gray-700 mb-1">(5) No. de control</label>
                  <input type="text" id="f-control" placeholder="Ej. 20210045" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition"/>
                </div>
                <div>
                  <label for="f-carrera" class="block text-sm font-medium text-gray-700 mb-1">(6) Carrera</label>
                  <select id="f-carrera" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition">
                    <option value="">Seleccionar...</option>
                    <option>Ing. en Sistemas Computacionales</option>
                    <option>Ing. Industrial</option>
                    <option>Ing. en Gestión Empresarial</option>
                    <option>Ing. Civil</option>
                    <option>Ing. en Tecnologías de la Información</option>
                  </select>
                </div>
                <div>
                  <label for="f-semestre" class="block text-sm font-medium text-gray-700 mb-1">(7) Semestre</label>
                  <input type="text" id="f-semestre" placeholder="Ej. 5" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition"/>
                </div>
                <div>
                  <label for="f-grupo" class="block text-sm font-medium text-gray-700 mb-1">(8) Grupo</label>
                  <input type="text" id="f-grupo" placeholder="Ej. A" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition"/>
                </div>
                <div>
                  <label for="f-turno" class="block text-sm font-medium text-gray-700 mb-1">(9) Turno</label>
                  <select id="f-turno" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition">
                    <option value="">Seleccionar...</option>
                    <option>Matutino</option>
                    <option>Vespertino</option>
                  </select>
                </div>
                <div>
                  <label for="f-aula" class="block text-sm font-medium text-gray-700 mb-1">(10) Aula</label>
                  <input type="text" id="f-aula" placeholder="Ej. B-12" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition"/>
                </div>
              </div>

              <div id="campo-procedencia" class="hidden">
                <label for="f-procedencia" class="block text-sm font-medium text-gray-700 mb-1">(11) Procedencia</label>
                <input type="text" id="f-procedencia" placeholder="Ej. Área, empresa, padre de familia..." class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition"/>
              </div>
            </div>

            {{-- Descripción --}}
            <div class="border-t border-gray-100 pt-4">
              <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-3">Descripción</p>
              <div>
                <label for="f-queja" class="block text-sm font-medium text-gray-700 mb-1">(12) Queja</label>
                <textarea id="f-queja" rows="3" placeholder="Describe de forma detallada y objetiva tu queja..." class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition resize-none"></textarea>
                <p id="err-queja" class="hidden text-xs text-red-500 mt-1">Describe tu queja.</p>
              </div>
              <div class="mt-4">
                <label for="f-sugerencia" class="block text-sm font-medium text-gray-700 mb-1">(13) Sugerencia</label>
                <textarea id="f-sugerencia" rows="3" placeholder="Describe tu sugerencia de mejora..." class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition resize-none"></textarea>
                <p id="err-sug" class="hidden text-xs text-red-500 mt-1">Describe tu sugerencia.</p>
              </div>
            </div>

            {{-- Fecha --}}
            <div class="border-t border-gray-100 pt-4">
              <label for="f-fecha" class="block text-sm font-medium text-gray-700 mb-1">(14) Fecha</label>
              <input type="date" id="f-fecha" class="border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 transition"/>
            </div>

            {{-- Privacidad --}}
            <div>
              <label class="flex items-start gap-3 cursor-pointer">
                <input type="checkbox" id="f-privacidad" class="w-4 h-4 mt-0.5 accent-[#01696f] shrink-0"/>
                <span class="text-xs text-gray-500 leading-relaxed">Acepto que mis datos sean tratados de forma <strong>confidencial</strong> conforme al aviso de privacidad institucional y la norma ISO 9001:2015.</span>
              </label>
              <p id="err-priv" class="hidden text-xs text-red-500 mt-1 ml-7">Debes aceptar el aviso de privacidad.</p>
            </div>

            {{-- Botones --}}
            <div class="flex gap-3 pt-1">
              <button type="submit" id="btn-enviar" class="flex-1 bg-[#01696f] hover:bg-[#0c4e54] text-white font-medium py-3 rounded-xl text-sm transition-colors">Enviar</button>
              <button type="button" onclick="goTo('bandeja')" class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-3 rounded-xl text-sm transition-colors">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- ===== PANTALLA: DETALLE ===== --}}
    <div id="screen-detalle" class="screen hidden">
      <div class="max-w-3xl w-full mx-auto space-y-4">
        <div class="flex items-center gap-2 flex-wrap">
          <button onclick="goTo('bandeja')" class="flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition-colors px-3 py-2 rounded-lg hover:bg-white border border-transparent hover:border-gray-200">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Volver
          </button>
          <button id="btn-editar-detalle" onclick="editarDesdeDetalle()" class="flex items-center gap-1.5 text-sm text-[#01696f] font-medium px-3 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Editar
          </button>
          <button id="btn-anular-detalle" onclick="anularDesdeDetalle()" class="flex items-center gap-1.5 text-sm text-red-500 font-medium px-3 py-2 rounded-lg bg-white border border-gray-200 hover:bg-red-50 transition-colors">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            Anular
          </button>
          <button onclick="window.print()" class="flex items-center gap-1.5 text-sm text-gray-600 font-medium px-3 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 transition-colors ml-auto">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Imprimir acuse
          </button>
        </div>

        <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
          <div class="bg-[#01696f] px-6 py-5 flex items-start justify-between gap-4">
            <div>
              <p class="text-white/70 text-xs mb-1 uppercase tracking-widest">Acuse de recibo · TecNM-CA-PO-004-01</p>
              <h2 class="text-white text-lg font-semibold">Tu queja y/o sugerencia fue enviada y será atendida</h2>
            </div>
            <div class="text-right shrink-0">
              <p class="text-white/60 text-xs mb-0.5">Folio</p>
              <p class="text-white font-bold font-mono text-xl tracking-widest" id="acuse-folio">—</p>
            </div>
          </div>
          <div class="p-6 space-y-5">
            <div class="flex items-center gap-3">
              <span id="acuse-badge" class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-blue-100 text-blue-700">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Pendiente de atención
              </span>
              <span class="text-xs text-gray-400" id="acuse-fecha-envio"></span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Solicitante</p>
                <p class="text-sm font-semibold text-gray-800" id="acuse-nombre">—</p>
                <p class="text-xs text-gray-500 mt-0.5" id="acuse-correo">—</p>
                <p class="text-xs text-gray-500" id="acuse-tel"></p>
              </div>
              <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-2">Datos académicos</p>
                <p class="text-sm text-gray-700" id="acuse-parte">—</p>
                <p class="text-xs text-gray-500 mt-0.5" id="acuse-datos-extra">—</p>
              </div>
            </div>
            <div id="acuse-queja-wrap">
              <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">(12) Queja</p>
              <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-xl p-4 border border-gray-100" id="acuse-queja">—</p>
            </div>
            <div id="acuse-sug-wrap">
              <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">(13) Sugerencia</p>
              <p class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-xl p-4 border border-gray-100" id="acuse-sug">—</p>
            </div>
            <div class="flex items-center justify-between text-xs text-gray-400 pt-2 border-t border-gray-100">
              <span id="acuse-fecha">(14) Fecha: —</span>
              <span>Instituto Tecnológico · TecNM</span>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

{{-- MODAL ANULAR --}}
<div id="modal-anular" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6">
    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
      <svg class="w-6 h-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    </div>
    <h3 class="text-base font-semibold text-gray-800 text-center mb-2">¿Anular este registro?</h3>
    <p class="text-sm text-gray-500 text-center mb-6">Esta acción marcará tu queja/sugerencia como <strong>anulada</strong>.</p>
    <div class="flex gap-3">
      <button onclick="cerrarModal()" class="flex-1 border border-gray-200 text-gray-600 text-sm py-2.5 rounded-xl hover:bg-gray-50 transition-colors">Cancelar</button>
      <button onclick="confirmarAnular()" class="flex-1 bg-red-500 hover:bg-red-600 text-white text-sm py-2.5 rounded-xl transition-colors font-medium">Sí, anular</button>
    </div>
  </div>
</div>

{{-- TOAST --}}
<div id="toast" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 hidden">
  <div class="bg-gray-800 text-white text-sm px-5 py-3 rounded-xl shadow-lg flex items-center gap-2" id="toast-inner">
    <span id="toast-msg"></span>
  </div>
</div>

@push('scripts')
<style>
  .screen { display: none; }
  .screen.active { display: block; }
  .active-filter { background-color: #01696f; color: white; }
</style>
<script>
const BASE  = '/buzon';
const CSRF  = document.querySelector('meta[name="csrf-token"]').content;

let registros    = @json($registros);
let currentFolio = null;
let editMode     = false;
let idAnular     = null;
let filtroActual = 'todas';

// ── FETCH ──────────────────────────────────────────
async function apiFetch(url, options = {}) {
  const res = await fetch(url, {
    headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN':CSRF, 'Accept':'application/json', ...options.headers },
    ...options
  });
  if (!res.ok) throw await res.json();
  return res.json();
}

async function recargar() {
  registros = await apiFetch(BASE);
}

// ── HELPERS ────────────────────────────────────────
function hoy() { return new Date().toISOString().split('T')[0]; }
function fechaLegible(f) {
  if (!f) return '—';
  const fecha = new Date(f);
  const d = String(fecha.getUTCDate()).padStart(2,'0');
  const m = String(fecha.getUTCMonth()+1).padStart(2,'0');
  return d+'/'+m+'/'+fecha.getUTCFullYear();
}

function goTo(name) {
  document.querySelectorAll('.screen').forEach(s => { s.classList.remove('active'); s.classList.add('hidden'); });
  const screen = document.getElementById('screen-'+name);
  if (!screen) return;
  screen.classList.remove('hidden');
  screen.classList.add('active');
  if (name === 'bandeja')  renderBandeja();
  if (name === 'redactar' && !editMode) resetForm();
}

function toggleParte() {
  const v = document.querySelector('input[name="parte"]:checked')?.value;
  document.getElementById('campos-alumno').classList.toggle('hidden', v !== 'alumno');
  document.getElementById('campo-procedencia').classList.toggle('hidden', v !== 'otro');
}

function estadoBadge(r) {
  if (r.anulado) return '<span class="text-xs px-2 py-0.5 rounded-full font-medium bg-gray-100 text-gray-500">Anulada</span>';
  const map = {
    pendiente:    '<span class="text-xs px-2 py-0.5 rounded-full font-medium bg-blue-50 text-blue-600">Pendiente</span>',
    'en proceso': '<span class="text-xs px-2 py-0.5 rounded-full font-medium bg-yellow-50 text-yellow-600">En proceso</span>',
    atendida:     '<span class="text-xs px-2 py-0.5 rounded-full font-medium bg-green-50 text-green-600">Atendida</span>'
  };
  return map[r.estado] || '';
}

// ── BANDEJA ────────────────────────────────────────
function filterBandeja(f, btn) {
  filtroActual = f;
  document.querySelectorAll('.filter-btn').forEach(b => {
    b.classList.remove('active-filter');
    b.classList.add('bg-white','border','border-gray-200','text-gray-600');
  });
  btn.classList.add('active-filter');
  btn.classList.remove('bg-white','border','border-gray-200','text-gray-600');
  renderBandeja();
}

function renderBandeja() {
  let datos = registros.filter(r => {
    if (filtroActual === 'todas')      return true;
    if (filtroActual === 'queja')      return r.tipo === 'queja';
    if (filtroActual === 'sugerencia') return r.tipo === 'sugerencia';
    if (filtroActual === 'pendiente')  return r.estado === 'pendiente' && !r.anulado;
    if (filtroActual === 'atendida')   return r.estado === 'atendida';
    return true;
  });

  const lista = document.getElementById('lista-bandeja');
  const vacia = document.getElementById('bandeja-vacia');

  if (!datos.length) {
    lista.innerHTML = '';
    vacia.classList.remove('hidden'); vacia.classList.add('flex');
    return;
  }
  vacia.classList.add('hidden'); vacia.classList.remove('flex');

  lista.innerHTML = datos.map(r => `
    <div class="flex items-center gap-4 px-5 py-3.5 hover:bg-gray-50 cursor-pointer transition-colors ${r.anulado ? 'opacity-50' : ''}" onclick="verDetalle('${r.folio}')">
      <div class="w-8 h-8 rounded-full ${r.tipo==='queja'?'bg-red-100':'bg-teal-100'} flex items-center justify-center shrink-0">
        <svg class="w-4 h-4 ${r.tipo==='queja'?'text-red-500':'text-[#01696f]'}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          ${r.tipo==='queja'
            ? '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>'
            : '<path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/>'}
        </svg>
      </div>
      <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2 mb-0.5">
          <span class="text-xs font-mono text-gray-400">${r.folio}</span>
          ${estadoBadge(r)}
          <span class="text-xs px-2 py-0.5 rounded-full ${r.tipo==='queja'?'bg-red-50 text-red-600':'bg-teal-50 text-teal-700'} font-medium capitalize">${r.tipo}</span>
        </div>
        <p class="text-sm font-medium text-gray-800 truncate">${(r.queja||r.sugerencia||'').substring(0,80)}</p>
      </div>
      <div class="text-right shrink-0">
        <p class="text-xs text-gray-400 tabular-nums">${fechaLegible(r.fecha)}</p>
        ${!r.anulado ? `<div class="flex gap-1.5 mt-1 justify-end">
          <button onclick="event.stopPropagation();editarRegistro('${r.folio}')" class="text-xs text-[#01696f] hover:underline">Editar</button>
          <span class="text-gray-200">|</span>
          <button onclick="event.stopPropagation();abrirModal(${r.id})" class="text-xs text-red-400 hover:underline">Anular</button>
        </div>` : ''}
      </div>
    </div>`).join('');
}

// ── DETALLE ────────────────────────────────────────
function verDetalle(folio) {
  const r = registros.find(x => x.folio === folio);
  if (!r) return;
  currentFolio = folio;

  document.getElementById('acuse-folio').textContent       = r.folio;
  document.getElementById('acuse-nombre').textContent      = r.nombre || '—';
  document.getElementById('acuse-correo').textContent      = r.correo || '—';
  document.getElementById('acuse-tel').textContent         = r.telefono ? 'Tel: '+r.telefono : '';
  document.getElementById('acuse-fecha-envio').textContent = 'Enviada el '+fechaLegible(r.fecha);
  document.getElementById('acuse-fecha').textContent       = '(14) Fecha: '+fechaLegible(r.fecha);

  if (r.parte === 'alumno') {
    document.getElementById('acuse-parte').textContent       = 'Alumno · '+r.carrera;
    document.getElementById('acuse-datos-extra').textContent = `Sem. ${r.semestre} · Grupo ${r.grupo} · ${r.turno} · Aula ${r.aula} · No.Control: ${r.no_control}`;
  } else {
    document.getElementById('acuse-parte').textContent       = 'Parte interesada';
    document.getElementById('acuse-datos-extra').textContent = r.procedencia || '—';
  }

  const qw = document.getElementById('acuse-queja-wrap');
  const sw = document.getElementById('acuse-sug-wrap');
  if (r.queja)      { qw.classList.remove('hidden'); document.getElementById('acuse-queja').textContent = r.queja; } else qw.classList.add('hidden');
  if (r.sugerencia) { sw.classList.remove('hidden'); document.getElementById('acuse-sug').textContent   = r.sugerencia; } else sw.classList.add('hidden');

  const badge = document.getElementById('acuse-badge');
  if (r.anulado) {
    badge.className = 'inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-gray-100 text-gray-500';
    badge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>Anulada';
  } else if (r.estado === 'atendida') {
    badge.className = 'inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-green-100 text-green-700';
    badge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Atendida';
  } else {
    badge.className = 'inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-full bg-blue-100 text-blue-700';
    badge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Pendiente de atención';
  }

  document.getElementById('btn-editar-detalle').classList.toggle('hidden', r.anulado);
  document.getElementById('btn-anular-detalle').classList.toggle('hidden', r.anulado);

  goTo('detalle');
  document.getElementById('page-title').textContent = 'Detalle · '+r.folio;
}

function editarDesdeDetalle() { editarRegistro(currentFolio); }
function anularDesdeDetalle() {
  const r = registros.find(x => x.folio === currentFolio);
  if (r) abrirModal(r.id);
}

// ── EDITAR ─────────────────────────────────────────
function editarRegistro(folio) {
  const r = registros.find(x => x.folio === folio);
  if (!r || r.anulado) return;
  editMode = true; currentFolio = folio;

  document.querySelector(`input[name="tipo"][value="${r.tipo}"]`).checked = true;
  document.getElementById('f-nombre').value     = r.nombre;
  document.getElementById('f-correo').value     = r.correo;
  document.getElementById('f-tel').value        = r.telefono || '';
  document.querySelector(`input[name="parte"][value="${r.parte}"]`).checked = true;
  toggleParte();
  document.getElementById('f-control').value    = r.no_control   || '';
  document.getElementById('f-carrera').value    = r.carrera      || '';
  document.getElementById('f-semestre').value   = r.semestre     || '';
  document.getElementById('f-grupo').value      = r.grupo        || '';
  document.getElementById('f-turno').value      = r.turno        || '';
  document.getElementById('f-aula').value       = r.aula         || '';
  document.getElementById('f-procedencia').value = r.procedencia || '';
  document.getElementById('f-queja').value      = r.queja        || '';
  document.getElementById('f-sugerencia').value = r.sugerencia   || '';
  document.getElementById('f-fecha').value      = r.fecha ? r.fecha.split('T')[0] : hoy();
  document.getElementById('f-privacidad').checked = true;
  document.getElementById('form-title').textContent     = 'Editar queja / sugerencia';
  document.getElementById('btn-enviar').textContent     = 'Guardar cambios';
  document.getElementById('form-folio-badge').textContent = folio;
  document.getElementById('form-folio-badge').classList.remove('hidden');
  goTo('redactar');
}

// ── ANULAR ─────────────────────────────────────────
function abrirModal(id) {
  idAnular = id;
  document.getElementById('modal-anular').classList.remove('hidden');
  document.getElementById('modal-anular').classList.add('flex');
}
function cerrarModal() {
  document.getElementById('modal-anular').classList.add('hidden');
  document.getElementById('modal-anular').classList.remove('flex');
  idAnular = null;
}
async function confirmarAnular() {
  try {
    await apiFetch(`${BASE}/${idAnular}/anular`, { method: 'PATCH' });
    cerrarModal();
    showToast('Registro anulado correctamente.', 'error');
    registros = await apiFetch(BASE);
    if (document.getElementById('screen-detalle').classList.contains('active')) verDetalle(currentFolio);
    else renderBandeja();
  } catch(e) { showToast('Error al anular','error'); }
}

// ── SUBMIT ─────────────────────────────────────────
async function handleSubmit(e) {
  e.preventDefault();
  let ok = true;
  const err = (id, show) => { document.getElementById(id).classList.toggle('hidden',!show); if(show) ok=false; };

  err('err-tipo',   !document.querySelector('input[name="tipo"]:checked'));
  err('err-nombre', !document.getElementById('f-nombre').value.trim());
  err('err-correo', !document.getElementById('f-correo').value.trim());
  err('err-parte',  !document.querySelector('input[name="parte"]:checked'));
  const tipo = document.querySelector('input[name="tipo"]:checked')?.value;
  err('err-queja', tipo==='queja'      && !document.getElementById('f-queja').value.trim());
  err('err-sug',   tipo==='sugerencia' && !document.getElementById('f-sugerencia').value.trim());
  err('err-priv',  !document.getElementById('f-privacidad').checked);
  if (!ok) return;

  const parte = document.querySelector('input[name="parte"]:checked')?.value;
  const datos = {
    tipo, parte,
    nombre:      document.getElementById('f-nombre').value.trim(),
    correo:      document.getElementById('f-correo').value.trim(),
    telefono:    document.getElementById('f-tel').value.trim(),
    no_control:  document.getElementById('f-control').value.trim(),
    carrera:     document.getElementById('f-carrera').value,
    semestre:    document.getElementById('f-semestre').value.trim(),
    grupo:       document.getElementById('f-grupo').value.trim(),
    turno:       document.getElementById('f-turno').value,
    aula:        document.getElementById('f-aula').value.trim(),
    procedencia: document.getElementById('f-procedencia').value.trim(),
    queja:       document.getElementById('f-queja').value.trim(),
    sugerencia:  document.getElementById('f-sugerencia').value.trim(),
    fecha:       document.getElementById('f-fecha').value || hoy(),
  };

  try {
    let resultado;
    if (editMode) {
      const r = registros.find(x => x.folio === currentFolio);
      resultado = await apiFetch(`${BASE}/${r.id}`, { method:'PUT', body: JSON.stringify(datos) });
      showToast('Cambios guardados correctamente.');
    } else {
      resultado = await apiFetch(BASE, { method:'POST', body: JSON.stringify(datos) });
      showToast('¡Enviada! Folio: '+resultado.folio);
    }
    editMode = false;
    registros = await apiFetch(BASE);
    verDetalle(resultado.folio);
  } catch(e) { showToast('Error al guardar. Intenta de nuevo.','error'); console.error(e); }
}

// ── RESET ──────────────────────────────────────────
function resetForm() {
  document.getElementById('buzon-form').reset();
  document.getElementById('form-title').textContent = 'Nueva queja / sugerencia';
  document.getElementById('btn-enviar').textContent = 'Enviar';
  document.getElementById('form-folio-badge').classList.add('hidden');
  document.getElementById('campos-alumno').classList.add('hidden');
  document.getElementById('campo-procedencia').classList.add('hidden');
  ['err-tipo','err-nombre','err-correo','err-parte','err-queja','err-sug','err-priv']
    .forEach(id => document.getElementById(id)?.classList.add('hidden'));
  document.getElementById('f-fecha').value = hoy();
  editMode = false;
}

// ── TOAST ──────────────────────────────────────────
function showToast(msg, type='ok') {
  const icon = type==='error'
    ? '<svg class="w-4 h-4 text-red-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>'
    : '<svg class="w-4 h-4 text-green-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>';
  document.getElementById('toast-inner').innerHTML = icon+'<span>'+msg+'</span>';
  const t = document.getElementById('toast');
  t.classList.remove('hidden');
  setTimeout(() => t.classList.add('hidden'), 3500);
}

// ── INIT ───────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('f-fecha').value = hoy();
  renderBandeja();
  const seccion = new URLSearchParams(window.location.search).get('seccion');
  if (seccion) goTo(seccion);
});
</script>
@endpush

@endsection