@php
    $role = auth()->user()->role;
@endphp

<aside class="no-print w-64 bg-white border-r border-gray-200 flex flex-col fixed top-0 left-0 h-full z-20 shadow-sm">

    <!-- BOTÓN -->
    <div class="px-4 py-4">
        @if($role === 'alumno')
            <a href="{{ route('alumno.dashboard') }}?seccion=redactar"
                class="w-full flex items-center justify-center gap-2 bg-[#01696f] hover:bg-[#0c4e54] text-white py-3 rounded-xl text-sm transition shadow-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19"/>
                    <line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Nueva queja / sugerencia
            </a>

        @elseif($role === 'admin')
            <a href="{{ route('admin.buzon.index') }}"
                class="w-full flex items-center justify-center gap-2 bg-[#01696f] hover:bg-[#0c4e54] text-white py-3 rounded-xl text-sm transition shadow-sm">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                Ir al buzón admin
            </a>

        @elseif($role === 'director')
            <a href="{{ route('director.exportar') }}"
                class="w-full flex items-center justify-center gap-2 bg-[#01696f] hover:bg-[#0c4e54] text-white py-3 rounded-xl text-sm transition shadow-sm">
                📥 Exportar registros
            </a>

        @elseif($role === 'subdirector')
            <a href="{{ route('subdirector.exportar') }}"
                class="w-full flex items-center justify-center gap-2 bg-[#01696f] hover:bg-[#0c4e54] text-white py-3 rounded-xl text-sm transition shadow-sm">
                📥 Exportar registros
            </a>
        @endif
    </div>

    <!-- NAV -->
    <nav class="px-3 flex-1 space-y-1">

        {{-- ALUMNO --}}
        @if($role === 'alumno')
            <a href="{{ route('alumno.dashboard') }}?seccion=bandeja"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->fullUrlIs('*seccion=bandeja*') ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                📥 Mis quejas
            </a>

            <a href="{{ route('alumno.dashboard') }}?seccion=consultar"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->fullUrlIs('*seccion=consultar*') ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                🔍 Consultar estatus
            </a>
        @endif

        {{-- ADMIN --}}
        @if($role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                🛠️ Panel administrador
            </a>

            <a href="{{ route('admin.buzon.index') }}"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.buzon.*') ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                📥 Buzón administrativo
            </a>

            <a href="{{ route('admin.usuarios.index') }}"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('admin.usuarios.*') ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                👥 Gestión de usuarios
            </a>

            <div class="border-t border-gray-100 my-2"></div>

            <a href="{{ route('alumno.dashboard') }}"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 transition text-gray-600">
                🎓 Vista Alumno
                <span class="ml-auto text-[10px] bg-amber-100 text-amber-600 px-2 py-0.5 rounded-full font-semibold leading-none">
                    Preview
                </span>
            </a>

            <a href="{{ route('director.dashboard') }}"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 transition text-gray-600">
                🏛️ Vista Director
                <span class="ml-auto text-[10px] bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full font-semibold">
                    Preview
                </span>
            </a>

            <a href="{{ route('subdirector.dashboard') }}"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 transition text-gray-600">
                🏢 Vista Subdirector
                <span class="ml-auto text-[10px] bg-sky-100 text-sky-600 px-2 py-0.5 rounded-full font-semibold">
                    Preview
                </span>
            </a>
        @endif

        {{-- DIRECTOR --}}
        @if($role === 'director')
            <a href="{{ route('director.dashboard') }}"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('director.dashboard') ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                🏛️ Panel del Director
            </a>
        @endif

        {{-- SUBDIRECTOR --}}
        @if($role === 'subdirector')
            <a href="{{ route('subdirector.dashboard') }}"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('subdirector.dashboard') ? 'bg-gray-100' : 'hover:bg-gray-100' }}">
                🏢 Panel del Subdirector
            </a>
        @endif

    </nav>

    <!-- USUARIO -->
    <div class="px-4 py-4 border-t border-gray-100 relative">

        <button onclick="toggleUserMenu()"
            class="w-full flex items-center gap-3 p-2 rounded-xl hover:bg-gray-100 transition">

            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#01696f] to-[#0c4e54]
                        flex items-center justify-center text-white font-bold text-sm shadow">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>

            <div class="text-left flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">
                    {{ Auth::user()->name ?? 'Usuario' }}
                </p>
                <p class="text-xs text-gray-400 truncate">
                    {{ Auth::user()->email ?? '' }}
                </p>
            </div>

            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6"/>
            </svg>
        </button>

        <div id="userMenu"
            class="hidden absolute bottom-full mb-2 left-0 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50">

            <a href="{{ route('perfil') }}"
               class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                👤 Mi perfil
            </a>

            <a href="{{ route('configuracion') }}"
               class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100 transition {{ request()->routeIs('configuracion') ? 'bg-gray-100 font-semibold' : '' }}">
                ⚙️ Configuración
            </a>

            <div class="border-t"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2 text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                    🔒 Cerrar sesión
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleUserMenu() {
            document.getElementById('userMenu').classList.toggle('hidden');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('[onclick="toggleUserMenu()"]') && !e.target.closest('#userMenu')) {
                document.getElementById('userMenu').classList.add('hidden');
            }
        });
    </script>

</aside>