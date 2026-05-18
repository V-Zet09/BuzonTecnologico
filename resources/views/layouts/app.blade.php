<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Buzón Institucional') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-100">

<div class="min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-blue-900 text-white shadow-md pl-64">
        <div class="px-6 py-4 flex items-center justify-between">

            <!-- Logo izquierda -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white text-blue-900 flex items-center justify-center rounded-full font-bold">
                    IT
                </div>

                <div>
                    <h1 class="text-lg font-semibold leading-tight">
                        Buzón Institucional
                    </h1>

                    <p class="text-xs text-blue-200">
                        TecNM - Ciudad Altamirano
                    </p>
                </div>
            </div>

            <!-- Branding derecha -->
            <div class="flex items-center gap-3">

                <div class="w-12 h-12 bg-white/10 border border-white/20 backdrop-blur-md 
                            flex items-center justify-center rounded-xl shadow-sm">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">

                        <path d="M4 6l8 7 8-7" />
                        <rect x="4" y="4" width="16" height="16" rx="2" />
                    </svg>

                </div>

                <div class="leading-tight text-right">
                    <p class="text-sm font-semibold text-white">
                        Buzón TEC
                    </p>

                    <p class="text-xs text-blue-200">
                        Sistema institucional
                    </p>
                </div>

            </div>

        </div>
    </header>

    <!-- CONTENIDO -->
    <div class="flex flex-1">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- CONTENIDO PRINCIPAL --}}
        <main class="flex-1 ml-64">

            @isset($header)
                <div class="bg-white shadow-sm border-b">
                    <div class="max-w-7xl mx-auto px-6 py-4">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            @yield('content')

        </main>

    </div>

    <!-- FOOTER -->
    <footer class="bg-blue-900 text-blue-200 text-center text-xs py-3 ml-64">
        © {{ date('Y') }} Instituto Tecnológico · Sistema de Buzón
    </footer>

</div>

@stack('scripts')

</body>
</html>