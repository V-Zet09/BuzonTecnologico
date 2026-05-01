<aside class="no-print w-64 bg-white border-r border-gray-200 flex flex-col fixed top-0 left-0 h-full z-20 shadow-sm">

    <!-- BOTÓN -->
    <div class="px-4 py-4">
        <button onclick="goTo('redactar')"
            class="w-full flex items-center justify-center gap-2 bg-[#01696f] hover:bg-[#0c4e54] text-white py-3 rounded-xl text-sm transition shadow-sm">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Nueva queja / sugerencia
        </button>
    </div>

    <!-- NAV -->
    <nav class="px-3 flex-1 space-y-1">
        <button onclick="goTo('bandeja')"
            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium bg-gray-100">
            📥 Mis quejas
        </button>

        <button onclick="goTo('consultar')"
            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-100">
            🔍 Consultar estatus
        </button>
    </nav>

    <!-- USUARIO -->
    <div class="px-4 py-4 border-t border-gray-100 relative">

        <button onclick="toggleUserMenu()" 
            class="w-full flex items-center gap-3 p-2 rounded-xl hover:bg-gray-100 transition">

            <!-- FOTO O INICIALES -->
            @if(Auth::user()->foto ?? false)
                <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                    class="w-10 h-10 rounded-full object-cover border">
            @else
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-[#01696f] to-[#0c4e54] 
                            flex items-center justify-center text-white font-bold text-sm shadow">
                    
                    {{ strtoupper(substr(Auth::user()->nombre ?? 'U', 0, 2)) }}
                </div>
            @endif

            <!-- INFO -->
            <div class="text-left flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">
                    {{ Auth::user()->nombre ?? 'Usuario' }}
                </p>
                <p class="text-xs text-gray-400 truncate">
                    {{ Auth::user()->correo ?? '' }}
                </p>
            </div>

            <!-- ICONO -->
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 9l6 6 6-6"/>
            </svg>

        </button>

        <!-- DROPDOWN -->
        <div id="userMenu"
            class="hidden absolute bottom-full mb-2 left-0 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden z-50">

            <a href="#"
                class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
                👤 Mi perfil
            </a>

            <a href="#"
                class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition">
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