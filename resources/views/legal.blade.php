<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Términos y condiciones y política de privacidad de {{ $empresa['nombre'] }}">
    <title>Términos y privacidad | {{ $empresa['nombre'] }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-slate-800 antialiased">

<header class="border-b border-slate-200">
    <nav class="mx-auto flex max-w-3xl items-center justify-between px-4 py-3">
        <a href="{{ route('inicio') }}" class="flex items-center gap-2 text-xl font-bold text-marca-700">
            <img src="{{ asset('favicon.svg') }}" alt="" class="h-8 w-8"> SoftTech
        </a>
        <a href="{{ route('inicio') }}" class="text-sm font-medium hover:text-marca-600">Volver al inicio</a>
    </nav>
</header>

<main class="mx-auto max-w-3xl space-y-10 px-4 py-10 leading-relaxed">
    <p class="text-sm text-slate-500">Vigentes desde el 18 de noviembre de 2026.</p>

    <section id="terminos" class="space-y-3">
        <h1 class="text-2xl font-bold text-marca-700">Términos y condiciones</h1>
        <p>Al crear una cuenta en {{ $producto['nombre'] }}, de {{ $empresa['nombre'] }}, aceptas estos términos.</p>
        <h2 class="font-semibold">1. Servicio</h2>
        <p>El servicio separa la voz y el instrumental de los videos o audios que subes, transcribe y sincroniza la letra, y te permite cantar en el Modo Karaoke desde la web o la aplicación Android.</p>
        <h2 class="font-semibold">2. Cuenta</h2>
        <p>Debes registrarte con datos verdaderos y cuidar tu contraseña. Eres responsable de lo que se haga con tu cuenta.</p>
        <h2 class="font-semibold">3. Planes y pagos</h2>
        <p>El plan Gratuito permite procesar 3 canciones al mes. El plan Premium cuesta USD 2 al mes, permite canciones ilimitadas y se paga por QR o transferencia; el equipo lo activa en tu cuenta al confirmar el pago.</p>
        <h2 class="font-semibold">4. Contenido que subes</h2>
        <p>Solo puedes subir contenido sobre el que tengas derechos o que uses para fines personales y privados. No puedes usar el servicio para distribuir ni vender obras de terceros. Las pistas generadas son para tu uso personal.</p>
        <h2 class="font-semibold">5. Disponibilidad</h2>
        <p>Hacemos lo posible para que el servicio esté disponible, pero puede tener interrupciones por mantenimiento o fallas. Podemos suspender una cuenta que incumpla estos términos.</p>
        <h2 class="font-semibold">6. Cambios y ley aplicable</h2>
        <p>Si cambiamos estos términos, lo avisaremos en este sitio. Se rigen por las leyes del Estado Plurinacional de Bolivia.</p>
    </section>

    <section id="privacidad" class="space-y-3">
        <h1 class="text-2xl font-bold text-marca-700">Política de privacidad</h1>
        <h2 class="font-semibold">1. Datos que guardamos</h2>
        <p>Tu nombre, tu correo, tu contraseña cifrada, la fecha en que aceptaste estos términos, los videos o audios que subes con los archivos que se generan y, si usas la aplicación móvil, el identificador de tu celular para enviarte notificaciones.</p>
        <h2 class="font-semibold">2. Para qué los usamos</h2>
        <p>Solo para darte el servicio: procesar tus canciones, mostrarte su avance, avisarte cuando estén listas y controlar tu plan. No vendemos ni compartimos tus datos con fines publicitarios.</p>
        <h2 class="font-semibold">3. Grabaciones y notificaciones</h2>
        <p>Las grabaciones de tu voz se guardan solo en tu celular y no se envían a nuestros servidores. El identificador para notificaciones se elimina al cerrar sesión.</p>
        <h2 class="font-semibold">4. Servicios de terceros</h2>
        <p>Usamos servidores en la nube para alojar el servicio, Firebase Cloud Messaging para las notificaciones, Tawk.to para el chat y un servicio de inteligencia artificial de Google para el asistente de este sitio.</p>
        <h2 class="font-semibold">5. Tus derechos</h2>
        <p>Puedes pedir ver, corregir o eliminar tus datos y tu cuenta escribiéndonos por el chat o el formulario de contacto, conforme al derecho a la privacidad que reconoce la Constitución Política del Estado.</p>
        <h2 class="font-semibold">6. Contacto</h2>
        <p>{{ $empresa['nombre'] }}, {{ $empresa['ciudad'] }}. Escríbenos desde la sección <a href="{{ route('inicio') }}#contacto" class="text-marca-600 hover:underline">Contacto</a>.</p>
    </section>
</main>

<footer class="border-t border-slate-200">
    <p class="mx-auto max-w-3xl px-4 py-6 text-sm text-slate-500">&copy; {{ date('Y') }} {{ $empresa['nombre'] }}. {{ $empresa['ciudad'] }}.</p>
</footer>
</body>
</html>
