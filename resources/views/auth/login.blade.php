<!DOCTYPE html>
<html lang="es" class="h-full bg-[#ECE5DE]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.A.L.L. H.S. — Iniciar Sesión</title>

    <!-- Tipografía distintiva de Gran Hotel: Cormorant Garamond + Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Framework CSS utilitario: Tailwind CSS cargado vía CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Cormorant Garamond"', 'Georgia', 'serif'],
                    },
                }
            }
        }
    </script>

    <!-- Librería oficial de iconos vectoriales: Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .banner-3d-burgundy {
            background: radial-gradient(circle at top right, #521B2A 0%, #2B0D16 65%, #17050A 100%);
            border-bottom: 4px solid #120408;
        }
        .card-3d-champagne {
            background: linear-gradient(180deg, #FFFFFF 0%, #F9F4EF 100%);
            border: 1px solid #D8C9BE;
            border-bottom: 5px solid #BFA99B;
            box-shadow: 
                0 18px 36px -8px rgba(43, 13, 22, 0.20),
                0 4px 12px -2px rgba(43, 13, 22, 0.10),
                inset 0 1px 0 rgba(255, 255, 255, 0.98);
        }
        .recessed-3d-champagne {
            background-color: #F2EAE3;
            border: 1px solid #D1C0B4;
            box-shadow: 
                inset 0 2px 6px rgba(43, 13, 22, 0.12),
                0 1px 0 rgba(255, 255, 255, 0.9);
        }
        .btn-3d-bronze {
            background: linear-gradient(180deg, #CF9A67 0%, #A66E3E 100%);
            border: 1px solid #8A582E;
            border-bottom: 3px solid #5E391A;
            box-shadow: 
                0 5px 12px rgba(166, 110, 62, 0.35),
                inset 0 1px 0 rgba(255, 245, 235, 0.50);
            transition: all 0.15s ease;
        }
        .btn-3d-bronze:hover {
            background: linear-gradient(180deg, #D9A675 0%, #B37846 100%);
            transform: translateY(-1px);
        }
        .btn-3d-bronze:active {
            transform: translateY(2px);
            border-bottom-width: 1px;
        }
    </style>
</head>
<body class="min-h-full flex flex-col justify-between text-stone-800 font-sans antialiased p-4 sm:p-6">

    <!-- BARRA SUPERIOR DE RETORNO -->
    <header class="max-w-md w-full mx-auto pt-2 flex items-center justify-between text-xs">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-[#4A1926] hover:text-[#2B0D16] font-bold transition-colors">
            <i class="bi bi-arrow-left"></i>
            <span>Volver al portal</span>
        </a>
        <span class="text-[11px] uppercase tracking-[0.2em] text-stone-500 font-bold">Acceso Corporativo</span>
    </header>

    <!-- TARJETA CENTRAL ASIMÉTRICA DE AUTENTICACIÓN -->
    <main class="max-w-md w-full mx-auto my-8">
        <div class="card-3d-champagne rounded-tl-[2.25rem] rounded-br-[2.25rem] rounded-tr-none rounded-bl-none overflow-hidden">

            <!-- Cabecera esculpida en Borgoña profundo -->
            <div class="banner-3d-burgundy px-6 sm:px-8 pt-8 pb-7 text-center space-y-2.5 text-white">
                <div class="w-12 h-12 rounded-tl-2xl rounded-br-2xl rounded-tr-none rounded-bl-none btn-3d-bronze text-white font-serif font-bold text-2xl flex items-center justify-center mx-auto">
                    S
                </div>
                <div>
                    <h1 class="font-serif text-3xl font-bold text-[#FDF8F4] tracking-tight">S.A.L.L. H.S.</h1>
                    <p class="text-[10px] uppercase tracking-[0.24em] text-[#E6BE9A] font-bold mt-1">
                        Sistema de Gestión Hotelera
                    </p>
                </div>
            </div>

            <!-- Notificación de errores de autenticación -->
            @if ($errors->any())
                <div class="mx-6 sm:mx-8 mt-6 p-3.5 rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none bg-rose-50 border border-rose-300 text-rose-900 text-xs flex items-start gap-2.5">
                    <i class="bi bi-exclamation-circle-fill text-rose-700 text-sm shrink-0 mt-0.5"></i>
                    <div>
                        <p class="font-bold">Error de autenticación</p>
                        <p class="mt-0.5 text-rose-800">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <!-- Formulario principal con campos cóncavos 3D -->
            <form action="{{ route('login.post') }}" method="POST" class="p-6 sm:p-8 space-y-5 text-xs">
                @csrf

                <!-- Correo electrónico -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-[11px] font-bold uppercase tracking-wider text-[#2B0D16]">
                        Correo Electrónico
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#632234]">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="admin@sall.com"
                               class="w-full pl-10 pr-3.5 py-2.5 recessed-3d-champagne rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-900 placeholder-stone-400 focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all">
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="space-y-1.5">
                    <label for="password" class="block text-[11px] font-bold uppercase tracking-wider text-[#2B0D16]">
                        Contraseña
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[#632234]">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               required
                               placeholder="••••••••"
                               class="w-full pl-10 pr-3.5 py-2.5 recessed-3d-champagne rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-stone-900 placeholder-stone-400 focus:outline-none focus:border-[#4A1926] focus:bg-white transition-all">
                    </div>
                </div>

                <!-- Botón táctil en bronce -->
                <div class="pt-1">
                    <button type="submit" 
                            class="btn-3d-bronze w-full py-3.5 px-4 text-white font-bold rounded-tl-xl rounded-br-xl rounded-tr-none rounded-bl-none text-xs uppercase tracking-wider flex items-center justify-center gap-2 cursor-pointer">
                        <i class="bi bi-box-arrow-in-right text-sm"></i>
                        <span>Ingresar al Sistema</span>
                    </button>
                </div>
            </form>

            <!-- PANEL DE ACCESO RÁPIDO PARA DEMOSTRACIÓN POR ROLES -->
            <div class="px-6 sm:px-8 py-4 bg-[#F3ECE6] border-t border-[#D8C9BE] space-y-2.5">
                <p class="text-[10px] uppercase tracking-widest text-stone-500 font-bold text-center">
                    Cuentas Demo por Departamento (Clave: 12345678)
                </p>
                <div class="flex flex-wrap justify-center gap-1.5 text-[11px]">
                    <button type="button" onclick="completarCredenciales('admin@sall.com')" class="px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-[#2B0D16] hover:bg-[#4A1926] text-[#F5DEC9] font-bold transition-colors cursor-pointer">
                        Admin
                    </button>
                    <button type="button" onclick="completarCredenciales('recepcion@sall.com')" class="px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-white hover:bg-[#FAF6F2] border border-[#D6C7BC] text-[#2B0D16] font-semibold transition-colors cursor-pointer">
                        Recepción
                    </button>
                    <button type="button" onclick="completarCredenciales('limpieza@sall.com')" class="px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-white hover:bg-[#FAF6F2] border border-[#D6C7BC] text-[#2B0D16] font-semibold transition-colors cursor-pointer">
                        Limpieza
                    </button>
                    <button type="button" onclick="completarCredenciales('comercial@sall.com')" class="px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-white hover:bg-[#FAF6F2] border border-[#D6C7BC] text-[#2B0D16] font-semibold transition-colors cursor-pointer">
                        Comercial
                    </button>
                    <button type="button" onclick="completarCredenciales('mantenimiento@sall.com')" class="px-2.5 py-1 rounded-tl-lg rounded-br-lg rounded-tr-none rounded-bl-none bg-white hover:bg-[#FAF6F2] border border-[#D6C7BC] text-[#2B0D16] font-semibold transition-colors cursor-pointer">
                        Mantenimiento
                    </button>
                </div>
            </div>

        </div>
    </main>

    <footer class="max-w-md w-full mx-auto pb-2 text-center text-[11px] text-stone-500">
        <span class="font-serif font-bold text-[#2B0D16]">S.A.L.L. H.S.</span> &copy; {{ date('Y') }} — Hotel Grand Central
    </footer>

    <script>
        /**
         * Rellena automáticamente el correo corporativo y la contraseña unificada
         * del rol seleccionado para agilizar las pruebas de demostración.
         */
        function completarCredenciales(correoCorporativo) {
            document.getElementById('email').value = correoCorporativo;
            document.getElementById('password').value = '12345678';
        }
    </script>

</body>
</html>