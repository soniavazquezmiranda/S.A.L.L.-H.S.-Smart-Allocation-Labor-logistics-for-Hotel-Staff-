<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.A.L.L. H.S. - Iniciar Sesión</title>
    <!-- Vinculación con vuestro CSS e inyección del motor de Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
        <!-- Cabecera Corporativa (Navy Blue) -->
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-8 text-center text-white relative">
            <div class="w-12 h-12 mx-auto mb-3 bg-amber-400 rounded-xl flex items-center justify-center shadow-lg text-slate-950 font-black text-xl">
                S
            </div>
            <h1 class="text-2xl font-bold tracking-tight">S.A.L.L. H.S.</h1>
            <p class="text-xs text-slate-300 mt-1 uppercase tracking-wider font-medium">Sistema de Gestión Hotelera</p>
        </div>

        <!-- Formulario Conectado a la Base de Datos -->
        <div class="p-8">
            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required placeholder="ejemplo@hotel.com"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-700 uppercase mb-1">Contraseña</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all">
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full py-3 px-4 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-bold text-sm rounded-lg shadow-md hover:shadow-lg transition-all transform active:scale-95 uppercase tracking-wider">
                        Ingresar al Sistema
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
