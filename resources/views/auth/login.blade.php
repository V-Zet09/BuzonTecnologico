<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900">

    <div class="h-screen w-screen grid lg:grid-cols-2 overflow-hidden">

        <!-- FORMULARIO -->
        <div class="flex items-center justify-center p-6 overflow-y-auto">
            <div class="border border-slate-700 rounded-lg p-6 shadow-sm md:p-8 w-full max-w-md bg-slate-800">

                <div class="mb-8">
                    <h1 class="text-white text-3xl font-bold mb-4">Inicio de sesión</h1>
                    <p class="text-slate-400 text-base">
                        Inicia sesión en tu cuenta para acceder a todas las funciones y características de nuestra plataforma.
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                   <!-- EMAIL -->
                    <div>
                        <label class="mb-2 text-white text-sm block">Correo institucional</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full px-3 py-2 rounded-md bg-slate-700 text-white outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('email')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <label class="mb-2 text-white text-sm block">Contraseña</label>
                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full px-3 py-2 rounded-md bg-slate-700 text-white outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    <!-- REMEMBER -->
                    <div class="flex justify-between items-center text-sm">
                        <label class="flex items-center gap-2 text-slate-300">
                            <input type="checkbox" name="remember" class="accent-blue-500">
                            Recordarme
                        </label>

                        <a href="{{ route('password.request') }}" class="text-blue-400 hover:underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <!-- BUTTON -->
                    <button type="submit" class="block mx-auto text-white bg-gradient-to-r from-blue-500
    via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none 
    focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-full text-sm 
    px-4 py-2.5 text-center leading-5">
    Inicar Sesion
                </button>
                    <p class="text-center text-slate-400 text-sm">
                        ¿No tienes una cuenta?
                        <a href="{{ route('registro') }}" class="text-blue-400 hover:underline">Regístrate</a>
                    </p>

                </form>
            </div>
        </div>

        <!-- IMAGEN -->
        <div class="hidden lg:block relative overflow-hidden">
            <img
                src="{{ asset('images/login.jpeg') }}"
                class="absolute inset-0 w-full h-full object-cover"
                alt="login img"
            >
        </div>

    </div>

</body>
</html>