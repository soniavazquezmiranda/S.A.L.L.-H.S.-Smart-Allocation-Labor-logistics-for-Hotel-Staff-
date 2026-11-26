<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.A.L.L. H.S. — Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4 text-slate-800">

    <div class="max-w-md w-full bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
        <div class="bg-slate-900 p-6 text-center text-white">
            <h1 class="text-xl font-bold text-amber-400">S.A.L.L. H.S.</h1>
            <p class="text-xs text-slate-400 mt-1">Control de Acceso y Roles</p>
        </div>

        @if ($errors->any())
            <div class="mx-6 mt-4 p-3 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="p-6 space-y-4 text-sm">
            @csrf
            <div>
                <label for="email" class="block font-semibold mb-1">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:border-slate-900">
            </div>

            <div>
                <label for="password" class="block font-semibold mb-1">Contraseña</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:border-slate-900">
            </div>

            <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-lg">
                Entrar
            </button>
        </form>

        <!-- Botones rápidos de prueba por rol -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 text-xs space-y-2">
            <p class="text-slate-500 font-semibold text-center">Acceso rápido (Clave: 12345678)</p>
            <div class="flex flex-wrap justify-center gap-1.5">
                <button type="button" onclick="setCreds('admin@sall.com')" class="px-2.5 py-1 bg-slate-800 text-white rounded">Admin</button>
                <button type="button" onclick="setCreds('recepcion@sall.com')" class="px-2.5 py-1 bg-white border border-slate-300 rounded">Recepción</button>
                <button type="button" onclick="setCreds('gobernanta@sall.com')" class="px-2.5 py-1 bg-white border border-slate-300 rounded">Gobernanta</button>
                <button type="button" onclick="setCreds('comercial@sall.com')" class="px-2.5 py-1 bg-white border border-slate-300 rounded">Comercial</button>
                <button type="button" onclick="setCreds('trabajador@sall.com')" class="px-2.5 py-1 bg-white border border-slate-300 rounded">Trabajador</button>
            </div>
        </div>
    </div>

    <script>
        function setCreds(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = '12345678';
        }
    </script>
</body>
</html>