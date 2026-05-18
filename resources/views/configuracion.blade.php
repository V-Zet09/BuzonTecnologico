@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen bg-gray-50">

    <div class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
        <div>
            <h1 class="text-base font-semibold text-gray-800">Configuración</h1>
            <p class="text-xs text-gray-400">
                {{ $esAdmin ? 'Panel de administración · BuzónTEC' : 'Preferencias de cuenta · BuzónTEC' }}
            </p>
        </div>
        <span class="text-xs text-gray-400">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
    </div>

    @if(session('success'))
        <div class="mx-6 mt-4 bg-[#e1f5ee] border border-[#01696f]/20 text-[#0f6e56] text-sm px-4 py-3 rounded-xl flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mx-6 mt-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-6 max-w-5xl mx-auto w-full space-y-4">

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="bg-white rounded-xl border border-black/5 p-4">
                <p class="text-xs text-gray-400 mb-1">{{ $esAdmin ? 'Registros totales' : 'Mis registros' }}</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['total_registros'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-black/5 p-4">
                <p class="text-xs text-gray-400 mb-1">Pendientes</p>
                <p class="text-2xl font-semibold text-blue-600">{{ $stats['pendientes'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-black/5 p-4">
                <p class="text-xs text-gray-400 mb-1">Atendidas</p>
                <p class="text-2xl font-semibold text-[#01696f]">{{ $stats['atendidas'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-black/5 p-4">
                <p class="text-xs text-gray-400 mb-1">{{ $esAdmin ? 'Usuarios habilitados' : 'Cuenta activa' }}</p>
                <p class="text-2xl font-semibold text-gray-800">{{ $stats['usuarios_activos'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
            <button onclick="toggleSection('perfil')"
                class="w-full flex items-center gap-3 px-5 py-4 border-b border-gray-100 hover:bg-gray-50 transition text-left">
                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
                <div class="flex-1 text-left">
                    <p class="text-sm font-semibold text-gray-800">Mi perfil</p>
                    <p class="text-xs text-gray-400">Nombre, correo y contraseña de acceso</p>
                </div>
                <svg id="chev-perfil" class="w-4 h-4 text-gray-400 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 9l6 6 6-6"/>
                </svg>
            </button>

            <div id="body-perfil" class="hidden p-5 space-y-4">
                <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-full bg-[#e1f5ee] flex items-center justify-center text-[#01696f] font-bold text-lg">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $user->email }}</p>
                        <span class="inline-block mt-1 text-xs bg-[#e1f5ee] text-[#0f6e56] px-2 py-0.5 rounded-full font-medium capitalize">
                            {{ $user->role }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('perfil.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 focus:border-[#01696f] transition"/>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 focus:border-[#01696f] transition"/>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Contraseña nueva</label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 focus:border-[#01696f] transition"/>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#01696f]/40 focus:border-[#01696f] transition"/>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('perfil') }}" class="text-sm border border-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-50 transition">
                            Ver perfil
                        </a>
                        <button type="submit" class="text-sm bg-[#01696f] hover:bg-[#0c4e54] text-white px-4 py-2 rounded-lg transition font-medium">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
            <button onclick="toggleSection('notif')"
                class="w-full flex items-center gap-3 px-5 py-4 border-b border-gray-100 hover:bg-gray-50 transition text-left">
                <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800">Notificaciones</p>
                    <p class="text-xs text-gray-400">Preferencias de avisos del sistema</p>
                </div>
                <svg id="chev-notif" class="w-4 h-4 text-gray-400 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 9l6 6 6-6"/>
                </svg>
            </button>

            <div id="body-notif" class="hidden divide-y divide-gray-50">
                @php
                    $notificaciones = [
                        ['key' => 'notif_nueva_queja', 'label' => 'Nueva queja recibida', 'desc' => 'Recibir aviso cuando entre una nueva queja'],
                        ['key' => 'notif_atendida', 'label' => 'Registro atendido', 'desc' => 'Recibir aviso cuando un registro se marque como atendido'],
                        ['key' => 'notif_anulada', 'label' => 'Registro anulado', 'desc' => 'Recibir aviso cuando un registro se anule'],
                        ['key' => 'notif_reporte_semanal', 'label' => 'Reporte semanal', 'desc' => 'Recibir resumen semanal del sistema'],
                    ];
                @endphp

                <form action="{{ route('admin.notificaciones.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    @foreach($notificaciones as $n)
                        <div class="flex items-center justify-between px-5 py-3.5">
                            <div>
                                <p class="text-sm text-gray-800">{{ $n['label'] }}</p>
                                <p class="text-xs text-gray-400">{{ $n['desc'] }}</p>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="{{ $n['key'] }}" value="1"
                                    {{ old($n['key'], $configuracion[$n['key']] ?? false) ? 'checked' : '' }}
                                    class="sr-only peer"/>
                                <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:bg-[#01696f] after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
                            </label>
                        </div>
                    @endforeach

                    <div class="px-5 py-3 flex justify-end">
                        <button type="submit" class="text-sm bg-[#01696f] hover:bg-[#0c4e54] text-white px-4 py-2 rounded-lg transition font-medium">
                            Guardar preferencias
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($esAdmin)
            <div class="bg-white rounded-2xl border border-black/5 shadow-sm overflow-hidden">
                <button onclick="toggleSection('usuarios')"
                    class="w-full flex items-center gap-3 px-5 py-4 border-b border-gray-100 hover:bg-gray-50 transition text-left">
                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Gestión de usuarios</p>
                        <p class="text-xs text-gray-400">Activar o desactivar cuentas del sistema</p>
                    </div>
                    <svg id="chev-usuarios" class="w-4 h-4 text-gray-400 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                <div id="body-usuarios" class="hidden divide-y divide-gray-50">
                    @forelse($usuarios as $usuario)
                        <div class="flex items-center gap-3 px-5 py-3">
                            <div class="w-9 h-9 rounded-full bg-[#e1f5ee] flex items-center justify-center text-[#01696f] font-bold text-sm shrink-0">
                                {{ strtoupper(substr($usuario->name, 0, 1)) }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $usuario->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $usuario->email }}</p>
                            </div>

                            <span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $usuario->activo ? 'bg-[#e1f5ee] text-[#0f6e56]' : 'bg-gray-100 text-gray-400' }}">
                                {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                            </span>

                            <form action="{{ route('admin.usuarios.toggle', $usuario->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="text-xs border px-3 py-1.5 rounded-lg transition {{ $usuario->activo ? 'border-red-200 text-red-500 hover:bg-red-50' : 'border-[#01696f]/30 text-[#01696f] hover:bg-[#e1f5ee]' }}">
                                    {{ $usuario->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="px-5 py-4 text-sm text-gray-400">
                            No hay otros usuarios para mostrar.
                        </div>
                    @endforelse

                    <div class="p-4 flex justify-end">
                        <a href="{{ route('admin.usuarios.create') }}"
                            class="flex items-center gap-2 text-sm bg-[#01696f] hover:bg-[#0c4e54] text-white px-4 py-2 rounded-lg transition font-medium">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Nuevo usuario
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-dashed border-amber-200 shadow-sm overflow-hidden">
                <button onclick="toggleSection('pendientes')"
                    class="w-full flex items-center gap-3 px-5 py-4 border-b border-amber-100 hover:bg-amber-50/50 transition text-left">
                    <svg class="w-5 h-5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Módulos pendientes</p>
                        <p class="text-xs text-gray-400">Categorías, exportación y acciones globales aún no implementadas</p>
                    </div>
                    <svg id="chev-pendientes" class="w-4 h-4 text-gray-400 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 9l6 6 6-6"/>
                    </svg>
                </button>

                <div id="body-pendientes" class="hidden p-5 space-y-3 text-sm text-gray-600">
                    <p>• Categorías de queja.</p>
                    <p>• Exportación real a PDF, Excel o CSV.</p>
                    <p>• Limpieza de registros anulados.</p>
                    <p>• Restablecimiento completo del sistema.</p>
                    <p class="text-amber-600 font-medium">Por ahora se dejaron fuera para no mostrar funciones incompletas como si ya fueran operativas.</p>
                </div>
            </div>
        @endif

    </div>
</div>

<script>
function toggleSection(id) {
    const body = document.getElementById('body-' + id);
    const chev = document.getElementById('chev-' + id);
    const isOpen = !body.classList.contains('hidden');
    body.classList.toggle('hidden', isOpen);
    chev.style.transform = isOpen ? '' : 'rotate(180deg)';
}
</script>
@endsection