<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi contraseña</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100">
    <div class="grid min-h-screen lg:grid-cols-2">

        <!-- Lado izquierdo -->
        <div class="hidden lg:flex flex-col justify-center bg-blue-800 text-white px-16 py-12">
            <div class="max-w-md">
                <div class="flex items-center mb-8">
                    <img class="w-10 h-10 mr-3" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
                    <span class="text-2xl font-bold">Mi sistema</span>
                </div>

                <h1 class="text-4xl font-extrabold leading-tight mb-6">
                    Recupera el acceso a tu cuenta
                </h1>

                <p class="text-blue-100 text-lg leading-relaxed mb-8">
                    Si olvidaste tu contraseña, ingresa tu correo electrónico y te enviaremos un enlace para restablecerla de forma segura.
                </p>

                <div class="space-y-4">
                    <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                        <p class="font-medium">Rápido y seguro</p>
                        <p class="text-sm text-blue-100">Recibe un enlace de recuperación directamente en tu correo.</p>
                    </div>

                    <div class="bg-white/10 rounded-xl p-4 backdrop-blur-sm">
                        <p class="font-medium">Acceso protegido</p>
                        <p class="text-sm text-blue-100">El cambio de contraseña se realiza mediante un enlace único.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lado derecho -->
        <div class="flex items-center justify-center px-6 py-8 bg-gray-50">
            <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
                <div class="lg:hidden flex items-center justify-center mb-6">
                    <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
                    <span class="text-xl font-bold text-gray-900">Mi sistema</span>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    ¿Olvidaste tu contraseña?
                </h2>

                <p class="text-sm text-gray-500 mb-6">
                    Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                </p>

                @if (session('status'))
                    <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                            Correo electrónico
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="nombre@empresa.com"
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-sm text-gray-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            required
                            autofocus
                        >

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300"
                    >
                        Enviar enlace de recuperación
                    </button>

                    <p class="text-sm text-center text-gray-500">
                        ¿Recordaste tu contraseña?
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">
                            Iniciar sesión
                        </a>
                    </p>
                </form>
            </div>
        </div>

    </div>
</body>
</html>