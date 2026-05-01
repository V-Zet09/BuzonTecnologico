<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro — Buzón Institucional TecNM</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            tec: {
              blue:   '#1a4f8a',
              teal:   '#0f7b6e',
              teallt: '#13a594',
              accent: '#17c3b2',
              light:  '#f0f7ff',
              muted:  '#6b7a90',
            }
          },
          fontFamily: {
            sans: ['DM Sans', 'sans-serif'],
            mono: ['DM Mono', 'monospace'],
          }
        }
      }
    }
  </script>
</head>
<body class="min-h-screen bg-tec-light flex flex-col items-center justify-center font-sans px-4">

  <!-- Logo / encabezado -->
  <div class="mb-6 text-center">
    <div class="w-12 h-12 rounded-full bg-tec-blue flex items-center justify-center text-white font-bold text-lg mx-auto mb-3">IT</div>
    <h1 class="text-xl font-bold text-tec-blue">Buzón Institucional</h1>
    <p class="text-sm text-tec-muted">TecNM — Ciudad Altamirano</p>
  </div>

  <!-- Tarjeta -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 w-full max-w-2xl">

    <!-- Encabezado tarjeta -->
    <div class="bg-tec-blue rounded-t-2xl px-6 py-4 flex items-center gap-2">
      <svg class="w-5 h-5 text-tec-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
      </svg>
      <span class="text-white font-semibold text-sm">Crear cuenta nueva</span>
    </div>

    <!-- Formulario -->
    <form action="{{ route('registro.store') }}" method="POST"
          class="p-6 grid grid-cols-2 gap-x-5 gap-y-4" novalidate>
      @csrf

      <!-- Nombre -->
      <div class="col-span-1">
        <label class="block text-xs font-semibold text-tec-blue mb-1.5 uppercase tracking-wide" for="nombre">Nombre(s)</label>
        <input id="nombre" name="nombre" type="text"
               class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 outline-none focus:border-tec-teallt focus:ring-2 focus:ring-tec-accent/20 transition-all"
               placeholder="Ej. José Luis" value="{{ old('nombre') }}"/>
        @error('nombre')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Apellidos -->
      <div class="col-span-1">
        <label class="block text-xs font-semibold text-tec-blue mb-1.5 uppercase tracking-wide" for="apellidos">Apellidos</label>
        <input id="apellidos" name="apellidos" type="text"
               class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 outline-none focus:border-tec-teallt focus:ring-2 focus:ring-tec-accent/20 transition-all"
               placeholder="Ej. García Mendoza" value="{{ old('apellidos') }}"/>
        @error('apellidos')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Sexo -->
      <div class="col-span-1">
        <label class="block text-xs font-semibold text-tec-blue mb-1.5 uppercase tracking-wide" for="sexo">Sexo</label>
        <select id="sexo" name="sexo"
                class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-800 text-sm outline-none focus:border-tec-teallt focus:ring-2 focus:ring-tec-accent/20 transition-all cursor-pointer">
          <option value="">Seleccionar…</option>
          <option value="M" {{ old('sexo')=='M'?'selected':'' }}>Masculino</option>
          <option value="F" {{ old('sexo')=='F'?'selected':'' }}>Femenino</option>
          <option value="O" {{ old('sexo')=='O'?'selected':'' }}>Prefiero no decir</option>
        </select>
        @error('sexo')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Teléfono -->
      <div class="col-span-1">
        <label class="block text-xs font-semibold text-tec-blue mb-1.5 uppercase tracking-wide" for="telefono">Teléfono</label>
        <input id="telefono" name="telefono" type="tel" maxlength="10"
               class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 outline-none focus:border-tec-teallt focus:ring-2 focus:ring-tec-accent/20 transition-all font-mono"
               placeholder="10 dígitos" value="{{ old('telefono') }}"/>
        @error('telefono')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Matrícula -->
      <div class="col-span-1">
        <label class="block text-xs font-semibold text-tec-blue mb-1.5 uppercase tracking-wide" for="matricula">Matrícula</label>
        <input id="matricula" name="matricula" type="text" maxlength="8"
               class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 outline-none focus:border-tec-teallt focus:ring-2 focus:ring-tec-accent/20 transition-all font-mono tracking-widest"
               placeholder="Ej. 20210045" value="{{ old('matricula') }}"/>
        @error('matricula')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Correo -->
      <div class="col-span-1">
        <label class="block text-xs font-semibold text-tec-blue mb-1.5 uppercase tracking-wide" for="correo">Correo institucional</label>
        <input id="correo" name="correo" type="email"
               class="w-full px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-slate-800 text-sm placeholder-slate-400 outline-none focus:border-tec-teallt focus:ring-2 focus:ring-tec-accent/20 transition-all"
               placeholder="usuario@altamirano.tecnm.mx" value="{{ old('correo') }}"/>
        @error('correo')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Divider -->
      <div class="col-span-2 border-t border-slate-100 my-1"></div>

      <!-- Acciones -->
      <div class="col-span-2 flex items-center justify-between">
        <a href="{{ route('login') }}" class="text-sm text-tec-muted hover:text-tec-blue transition-colors">
          ¿Ya tienes cuenta? <span class="font-semibold underline underline-offset-2">Iniciar sesión</span>
        </a>
        <button type="submit"
          class="bg-tec-teal hover:bg-tec-teallt active:scale-95 text-white font-semibold text-sm px-6 py-2.5 rounded-lg transition-all duration-200 flex items-center gap-2 shadow-sm">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
          </svg>
          Registrarse
        </button>
      </div>

    </form>
  </div>

  <p class="text-xs text-tec-muted mt-6">TecNM-CA-PO-004-01 © 2026</p>

  <script>
    // Solo dígitos en teléfono
    document.getElementById('telefono').addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '').slice(0, 10);
    });

    // Validación correo en tiempo real
    document.getElementById('correo').addEventListener('input', function () {
      const bad = this.value.length > 0 && !this.value.endsWith('@altamirano.tecnm.mx');
      this.style.borderColor = bad ? '#f87171' : '';
    });
  </script>

</body>
</html>