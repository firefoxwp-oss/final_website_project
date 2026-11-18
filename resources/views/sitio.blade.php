<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $empresa['nombre'] }}: {{ $empresa['lema'] }}">
    <title>{{ $empresa['nombre'] }} | {{ $empresa['lema'] }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 antialiased">

{{-- Encabezado y menú --}}
<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
    <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
        <a href="#inicio" class="flex items-center gap-2 text-xl font-bold text-marca-700">
            <img src="{{ asset('favicon.svg') }}" alt="" class="h-8 w-8"> SoftTech
        </a>
        <ul class="hidden gap-6 text-sm font-medium md:flex">
            <li><a href="#productos" class="hover:text-marca-600">Productos</a></li>
            <li><a href="#planes" class="hover:text-marca-600">Planes</a></li>
            <li><a href="#descargas" class="hover:text-marca-600">Descargas</a></li>
            <li><a href="#preguntas" class="hover:text-marca-600">Preguntas frecuentes</a></li>
            <li><a href="#contacto" class="hover:text-marca-600">Contacto</a></li>
        </ul>
    </nav>
</header>

<main>
    {{-- Inicio --}}
    <section id="inicio" class="bg-gradient-to-br from-marca-800 to-marca-600 text-white">
        <div class="mx-auto max-w-6xl px-4 py-20 md:py-28">
            <p class="text-sm font-semibold uppercase tracking-widest text-marca-200">{{ $empresa['nombre'] }}</p>
            <h1 class="mt-3 max-w-3xl text-4xl font-bold leading-tight md:text-5xl">{{ $empresa['lema'] }}</h1>
            <p class="mt-5 max-w-2xl text-lg text-marca-100">{{ $empresa['descripcion'] }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="#productos" class="rounded-lg bg-white px-5 py-3 font-semibold text-marca-700 hover:bg-marca-50">Conoce nuestro producto</a>
                <a href="#descargas" class="rounded-lg border border-white/60 px-5 py-3 font-semibold hover:bg-white/10">Descargar la aplicación</a>
            </div>
        </div>
    </section>

    {{-- Productos --}}
    <section id="productos" class="mx-auto max-w-6xl px-4 py-16">
        <h2 class="text-3xl font-bold text-slate-900">Productos</h2>
        <div class="mt-8 grid gap-8 rounded-2xl border border-slate-200 p-6 shadow-sm md:grid-cols-2 md:p-10">
            <div>
                <h3 class="text-2xl font-semibold text-marca-700">{{ $producto['nombre'] }}</h3>
                <p class="mt-3 text-slate-600">{{ $producto['resumen'] }}</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ $producto['web_url'] }}" target="_blank" rel="noopener" class="rounded-lg bg-marca-600 px-5 py-3 font-semibold text-white hover:bg-marca-700">Abrir la aplicación web</a>
                    <a href="#descargas" class="rounded-lg border border-marca-600 px-5 py-3 font-semibold text-marca-700 hover:bg-marca-50">Descargar para Android</a>
                </div>
                <ul class="mt-6 space-y-2 text-sm text-slate-600">
                    @foreach ($producto['plataformas'] as $plataforma)
                        <li><span class="font-semibold text-slate-800">{{ $plataforma['nombre'] }}:</span> {{ $plataforma['detalle'] }}</li>
                    @endforeach
                </ul>
            </div>
            <ul class="space-y-3">
                @foreach ($producto['caracteristicas'] as $caracteristica)
                    <li class="flex gap-3 rounded-lg bg-slate-50 p-3">
                        <span class="mt-0.5 text-marca-600">&#10003;</span><span>{{ $caracteristica }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Planes --}}
    <section id="planes" class="mx-auto max-w-6xl px-4 pb-16">
        <h2 class="text-3xl font-bold text-slate-900">Planes</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-2">
            @foreach ($planes as $plan)
                <article class="rounded-2xl border {{ $loop->last ? 'border-marca-600 shadow-md' : 'border-slate-200' }} p-6">
                    <h3 class="text-xl font-semibold text-marca-700">{{ $plan['nombre'] }}</h3>
                    <p class="mt-2"><span class="text-3xl font-bold">{{ $plan['precio'] }}</span> <span class="text-slate-500">{{ $plan['periodo'] }}</span></p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-600">
                        @foreach ($plan['beneficios'] as $beneficio)
                            <li class="flex gap-2"><span class="text-marca-600">&#10003;</span>{{ $beneficio }}</li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
        <p class="mt-6 text-sm text-slate-600">{{ $comoPremium }}</p>
    </section>

    {{-- Descargas --}}
    <section id="descargas" class="bg-slate-50">
        <div class="mx-auto max-w-6xl px-4 py-16">
            <h2 class="text-3xl font-bold text-slate-900">Descargas</h2>
            <p class="mt-3 text-slate-600">Instala o actualiza la aplicación móvil para Android 8.0 o superior. Para actualizar, instala la versión más reciente sobre la anterior.</p>
            <div class="mt-8 space-y-4">
                @foreach ($versiones as $v)
                    <article class="flex flex-col gap-4 rounded-xl border border-slate-200 bg-white p-5 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">
                                Versión {{ $v['version'] }}
                                @if ($loop->first)
                                    <span class="ml-2 rounded-full bg-marca-100 px-2 py-0.5 text-xs font-semibold text-marca-700">Actual</span>
                                @endif
                            </h3>
                            <p class="text-sm text-slate-500">Publicada el {{ $v['fecha'] }}</p>
                            <ul class="mt-2 list-inside list-disc text-sm text-slate-600">
                                @foreach ($v['cambios'] as $cambio)
                                    <li>{{ $cambio }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @if ($loop->first)
                            <a href="{{ $v['url'] }}" download class="shrink-0 rounded-lg bg-marca-600 px-5 py-3 text-center font-semibold text-white hover:bg-marca-700">Descargar APK</a>
                        @else
                            <span class="shrink-0 text-sm text-slate-500">Reemplazada por la versión actual</span>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Preguntas frecuentes --}}
    <section id="preguntas" class="mx-auto max-w-4xl px-4 py-16">
        <h2 class="text-3xl font-bold text-slate-900">Preguntas frecuentes</h2>
        <p class="mt-3 text-slate-600">¿No encuentras tu respuesta? Pregúntale a nuestro asistente o escríbenos.</p>
        <div class="mt-8 divide-y divide-slate-200 rounded-xl border border-slate-200">
            @foreach ($preguntas as $p)
                <details class="group p-5">
                    <summary class="flex cursor-pointer list-none items-center justify-between font-semibold">
                        {{ $p['pregunta'] }}<span class="text-marca-600 transition group-open:rotate-45">+</span>
                    </summary>
                    <p class="mt-3 text-slate-600">{{ $p['respuesta'] }}</p>
                </details>
            @endforeach
        </div>
    </section>

    {{-- Contacto --}}
    <section id="contacto" class="bg-slate-50">
        <div class="mx-auto grid max-w-6xl gap-10 px-4 py-16 md:grid-cols-3">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Contacto</h2>
                <p class="mt-3 text-slate-600">Escríbenos por correo, por el chat o pregúntale a nuestro asistente inteligente.</p>
                <dl class="mt-6 space-y-3 text-sm">
                    <div><dt class="font-semibold">Correo</dt><dd><a href="mailto:{{ $empresa['correo'] }}" class="text-marca-700 hover:underline">{{ $empresa['correo'] }}</a></dd></div>
                    <div><dt class="font-semibold">Ubicación</dt><dd>{{ $empresa['ciudad'] }}</dd></div>
                    <div><dt class="font-semibold">Horario</dt><dd>{{ $empresa['horario'] }}</dd></div>
                </dl>
            </div>
            <form method="POST" action="{{ route('contacto') }}" class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:col-span-2">
                @csrf
                @if (session('enviado'))
                    <p class="rounded-lg bg-green-50 p-3 text-sm text-green-800">{{ session('enviado') }}</p>
                @endif
                @if (session('error'))
                    <p class="rounded-lg bg-red-50 p-3 text-sm text-red-800">{{ session('error') }}</p>
                @endif
                <div class="grid gap-4 md:grid-cols-2">
                    @foreach (['nombre' => 'Nombre', 'correo' => 'Correo electrónico'] as $campo => $etiqueta)
                        <label class="block text-sm font-medium">{{ $etiqueta }}
                            <input name="{{ $campo }}" type="{{ $campo === 'correo' ? 'email' : 'text' }}" value="{{ old($campo) }}" required
                                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none">
                            @error($campo)<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                    @endforeach
                </div>
                <label class="block text-sm font-medium">Asunto
                    <input name="asunto" value="{{ old('asunto') }}" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none">
                    @error('asunto')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </label>
                <label class="block text-sm font-medium">Mensaje
                    <textarea name="mensaje" rows="5" required class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-marca-500 focus:outline-none">{{ old('mensaje') }}</textarea>
                    @error('mensaje')<span class="text-xs text-red-600">{{ $message }}</span>@enderror
                </label>
                <button type="submit" class="rounded-lg bg-marca-600 px-6 py-3 font-semibold text-white hover:bg-marca-700">Enviar correo</button>
            </form>
        </div>
    </section>
</main>

<footer class="border-t border-slate-200">
    <div class="mx-auto flex max-w-6xl flex-col gap-2 px-4 py-6 text-sm text-slate-500 md:flex-row md:justify-between">
        <p>&copy; {{ date('Y') }} {{ $empresa['nombre'] }}. {{ $empresa['ciudad'] }}.</p>
        <p>
            <a href="{{ route('legal') }}#terminos" class="hover:text-marca-600">Términos y condiciones</a> ·
            <a href="{{ route('legal') }}#privacidad" class="hover:text-marca-600">Política de privacidad</a> ·
            {{ $empresa['correo'] }}
        </p>
    </div>
</footer>

{{-- Agente inteligente --}}
<div id="agente" class="fixed bottom-5 left-5 z-40">
    <section id="agente-panel" class="mb-3 hidden w-80 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl">
        <header class="bg-marca-700 px-4 py-3 text-white">
            <p class="font-semibold">Asistente SoftTech</p>
            <p class="text-xs text-marca-100">Agente inteligente: responde sobre la empresa y el producto</p>
        </header>
        <div id="agente-mensajes" class="h-72 space-y-3 overflow-y-auto p-4 text-sm">
            <p class="rounded-lg bg-slate-100 p-3">¡Hola! Soy el asistente de SoftTech. ¿En qué te ayudo?</p>
        </div>
        <form id="agente-form" data-url="{{ route('agente') }}" class="flex gap-2 border-t border-slate-200 p-3">
            <input id="agente-texto" maxlength="500" autocomplete="off" placeholder="Escribe tu pregunta" class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-marca-500 focus:outline-none">
            <button class="rounded-lg bg-marca-600 px-3 text-sm font-semibold text-white hover:bg-marca-700">Enviar</button>
        </form>
    </section>
    <button id="agente-boton" type="button" class="rounded-full bg-marca-600 px-5 py-3 font-semibold text-white shadow-lg hover:bg-marca-700">Asistente IA</button>
</div>

{{-- Chat con el equipo (Tawk.to) --}}
@if ($tawk['propiedad'] && $tawk['widget'])
    <script>
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement('script'), s0 = document.getElementsByTagName('script')[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/{{ $tawk['propiedad'] }}/{{ $tawk['widget'] }}';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
@endif
</body>
</html>
