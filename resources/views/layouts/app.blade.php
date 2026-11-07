<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.A.L.L. H.S. - Panel de Control</title>
    
    <!-- MANTENIDO INTACTO: Enlaces de CDN de Tailwind, Google y JSDelivr -->
    <script src="https://tailwindcss.com"></script>
    <link href="https://googleapis.com" rel="stylesheet">
    <link href="https://jsdelivr.net" rel="stylesheet">
    
    <!-- Cargamos  estilos limpios de app.css a través del Vite oficial -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">

    <div class="flex">
        <!-- SE INCLUYE EL MENÚ LATERAL UNA SOLA VEZ -->
        @include('partials.sidebar')

        <!-- Contenedor dinámico donde se inyectará el index de cada carpeta -->
        <main class="flex-1 p-6 md:p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>

