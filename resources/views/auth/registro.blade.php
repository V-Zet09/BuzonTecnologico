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

  <!-- Header -->
  <div class="mb-6 text-center">
    <div class="w-12 h-12 rounded-full bg-tec-blue flex items-center justify-center text-white font-bold text-lg mx-auto mb-3">IT</div>
    <h1 class="text-xl font-bold text-tec-blue">Buzón Institucional</h1>
    <p class="text-sm text-tec-muted">TecNM — Ciudad Altamirano</p>
  </div>

  <!-- Card -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 w-full max-w-2xl">

    <!-- Header card -->
    <div class="bg-tec-blue rounded-t-2xl px-6 py-4 flex items-center gap-2">
      <span class="text-white font-semibold text-sm">Crear cuenta nueva</span>
    </div>

    <!-- Form -->
    <form action="{{ route('registro.store') }}" method="POST"
          class="p-6 grid grid-cols-2 gap-x-5 gap-y-4">

      @csrf

      <!-- Nombre -->
      <div>
        <label class="text-xs font-semibold text-tec-blue">Nombre(s)</label>
        <input name="nombre" type="text" value="{{ old('nombre') }}"
          class="w-full px-4 py-2.5 border rounded-lg text-sm"
          placeholder="Ej. José Luis">
      </div>

      <!-- Apellidos -->
      <div>
        <label class="text-xs font-semibold text-tec-blue">Apellidos</label>
        <input name="apellidos" type="text" value="{{ old('apellidos') }}"
          class="w-full px-4 py-2.5 border rounded-lg text-sm"
          placeholder="Ej. García Mendoza">
      </div>

      <!-- Sexo -->
      <div>
        <label class="text-xs font-semibold text-tec-blue">Sexo</label>
        <select name="sexo" class="w-full px-4 py-2.5 border rounded-lg text-sm">
          <option value="">Seleccionar…</option>
          <option value="M">Masculino</option>
          <option value="F">Femenino</option>
          <option value="O">Prefiero no decir</option>
        </select>
      </div>

      <!-- Teléfono -->
      <div>
        <label class="text-xs font-semibold text-tec-blue">Teléfono</label>
        <input id="telefono" name="telefono" type="tel" maxlength="10"
          value="{{ old('telefono') }}"
          class="w-full px-4 py-2.5 border rounded-lg text-sm"
          placeholder="10 dígitos">
      </div>

      <!-- Matrícula -->
      <div>
        <label class="text-xs font-semibold text-tec-blue">Matrícula</label>
        <input name="matricula" type="text" maxlength="8"
          value="{{ old('matricula') }}"
          class="w-full px-4 py-2.5 border rounded-lg text-sm"
          placeholder="Ej. 20210045">
      </div>

      <!-- EMAIL (CORREGIDO) -->
      <div>
        <label class="text-xs font-semibold text-tec-blue">Correo institucional</label>
        <input id="email" name="email" type="email"
          value="{{ old('email') }}"
          class="w-full px-4 py-2.5 border rounded-lg text-sm"
          placeholder="usuario@altamirano.tecnm.mx">

        @error('email')
          <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Divider -->
      <div class="col-span-2 border-t my-2"></div>

      <!-- Actions -->
      <div class="col-span-2 flex justify-between items-center">

        <a href="{{ route('login') }}" class="text-sm text-gray-500">
          ¿Ya tienes cuenta? Inicia sesión
        </a>

        <button type="submit"
          class="bg-tec-teal text-white px-6 py-2.5 rounded-lg text-sm font-semibold">
          Registrarse
        </button>

      </div>

    </form>
  </div>

  <!-- JS -->
  <script>
    document.getElementById('telefono').addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '').slice(0, 10);
    });
  </script>

</body>
</html>