<?php

/*
| Contenido del sitio corporativo de SoftTech. Es la única fuente de datos del
| sitio: las secciones, el formulario y el agente inteligente leen de aquí.
*/

return [

    'empresa' => [
        'nombre' => 'SoftTech S.R.L.',
        'lema' => 'Software con inteligencia artificial para disfrutar la música',
        'descripcion' => 'SoftTech es una empresa boliviana de desarrollo de software con sede en Santa Cruz de la Sierra. '
            .'Desarrolla aplicaciones web y móviles que aplican inteligencia artificial al procesamiento de audio y video.',
        'ciudad' => 'Santa Cruz de la Sierra, Bolivia',
        'correo' => env('SOFTTECH_CORREO', 'contacto@softtech.com.bo'),
        // Buzón que recibe los mensajes del formulario (puede ser distinto del correo público);
        // si la variable está vacía se usa el correo público
        'correo_destino' => env('SOFTTECH_CORREO_DESTINO') ?: env('SOFTTECH_CORREO', 'contacto@softtech.com.bo'),
        'horario' => 'Lunes a viernes, de 8:30 a 18:30',
    ],

    'producto' => [
        'nombre' => 'Separador de Contenido de Videos (Karaoke)',
        'resumen' => 'Convierte tus canciones en pistas de karaoke y cántalas desde la web o desde tu celular, con la letra '
            .'sincronizada, la voz guía ajustable y el tono adaptado a tu voz.',
        'web_url' => env('PRODUCTO_WEB_URL', '#'),
        'caracteristicas' => [
            'Separación de la voz y del instrumental con inteligencia artificial (Demucs, con Spleeter como respaldo).',
            'Letra transcrita y sincronizada palabra por palabra.',
            'Procesamiento en segundo plano con aviso al terminar, en la web y en el celular.',
            'Modo Karaoke con la letra resaltada y el volumen de la voz guía ajustable.',
            'Cambio de tono del instrumental en semitonos, en la aplicación móvil.',
            'Grabación de tu interpretación sobre el instrumental, guardada en tu celular.',
        ],
        'plataformas' => [
            ['nombre' => 'Aplicación web', 'detalle' => 'Chrome, Firefox o Edge en su versión actual.'],
            ['nombre' => 'Aplicación móvil', 'detalle' => 'Android 8.0 o superior.'],
        ],
    ],

    'planes' => [
        [
            'nombre' => 'Gratuito',
            'precio' => 'USD 0',
            'periodo' => 'siempre',
            'beneficios' => [
                '3 canciones procesadas al mes.',
                'Todas las funciones: Modo Karaoke, voz guía, cambio de tono y grabación.',
                'Web y aplicación móvil.',
            ],
        ],
        [
            'nombre' => 'Premium',
            'precio' => 'USD 2',
            'periodo' => 'al mes',
            'beneficios' => [
                'Canciones ilimitadas.',
                'Todas las funciones: Modo Karaoke, voz guía, cambio de tono y grabación.',
                'Web y aplicación móvil.',
            ],
        ],
    ],
    'como_premium' => 'Para pasar al plan Premium, escríbenos por el chat o el formulario de contacto. Pagas por QR o '
        .'transferencia bancaria y activamos tu plan en tu cuenta.',

    'descargas' => [
        // Carpeta pública de los instaladores; una versión con 'url' propia (Google Drive) la usa en su lugar.
        'url_base' => env('DESCARGAS_URL', '/descargas'),
        'versiones' => [
            [
                'version' => '1.2.0',
                'fecha' => '17/11/2026',
                'archivo' => 'karaoke-v1.2.0.apk',
                // Instalador publicado en Google Drive (el mismo enlace del código QR)
                'url' => env('DESCARGA_APK_URL', 'https://drive.google.com/file/d/10dVsUT0tKkR-SMDfQUGUGi7XI9zgsgZ9/view?usp=sharing'),
                'cambios' => [
                    'Modo Karaoke en el celular con la letra sincronizada y la voz guía.',
                    'Cambio de tono del instrumental.',
                    'Grabación de la interpretación y lista de grabaciones.',
                ],
            ],
            [
                'version' => '1.1.0',
                'fecha' => '20/10/2026',
                'archivo' => 'karaoke-v1.1.0.apk',
                'cambios' => [
                    'Subida de videos desde la galería o la cámara.',
                    'Notificación cuando la canción está lista.',
                ],
            ],
            [
                'version' => '1.0.0',
                'fecha' => '22/09/2026',
                'archivo' => 'karaoke-v1.0.0.apk',
                'cambios' => [
                    'Inicio de sesión con la cuenta de la web.',
                    'Lista de canciones procesadas.',
                ],
            ],
        ],
    ],

    'preguntas' => [
        [
            'pregunta' => '¿Qué archivos puedo subir?',
            'respuesta' => 'Videos MP4, AVI, MKV, MOV, M4V o WEBM y audios MP3, de hasta 1 GB y 60 minutos de duración.',
        ],
        [
            'pregunta' => '¿Cuánto tarda en procesarse una canción?',
            'respuesta' => 'Una canción de 4 minutos se procesa en 20 minutos o menos. No necesitas esperar con la '
                .'aplicación abierta: el procesamiento continúa en segundo plano y recibes un aviso al terminar.',
        ],
        [
            'pregunta' => '¿Cómo instalo la aplicación móvil?',
            'respuesta' => 'Descarga el instalador (APK) desde la sección Descargas, ábrelo en tu celular Android y, si el '
                .'sistema lo pide, permite la instalación desde esta fuente. Luego inicia sesión con tu cuenta de la web.',
        ],
        [
            'pregunta' => '¿Cómo actualizo la aplicación?',
            'respuesta' => 'Descarga la versión más reciente desde la sección Descargas e instálala sobre la anterior; tus '
                .'canciones y grabaciones se conservan.',
        ],
        [
            'pregunta' => '¿Puedo cancelar una canción que se está procesando?',
            'respuesta' => 'Sí. En la lista de procesamientos puedes cancelar una canción en espera o en curso.',
        ],
        [
            'pregunta' => '¿Cómo cambio el tono de una canción?',
            'respuesta' => 'En el Modo Karaoke de la aplicación móvil, sube o baja el tono hasta 6 semitonos. La primera vez '
                .'que eliges un tono tarda unos segundos; después el cambio es inmediato.',
        ],
        [
            'pregunta' => '¿Dónde se guardan mis grabaciones?',
            'respuesta' => 'Solo en tu celular: las grabaciones no se suben al servidor. Recomendamos usar audífonos al '
                .'grabar para que el micrófono no capte el instrumental.',
        ],
        [
            'pregunta' => '¿La letra no coincide con el audio, qué hago?',
            'respuesta' => 'Con audífonos Bluetooth puede haber un pequeño retraso. Ajusta la sincronía en el Modo Karaoke '
                .'hasta que la letra coincida con la canción.',
        ],
        [
            'pregunta' => '¿Cómo descargo mis resultados?',
            'respuesta' => 'En la web, abre la canción procesada y descarga cada pista, los subtítulos o el video karaoke por '
                .'separado, o todo junto en un archivo ZIP.',
        ],
    ],

    'tawk' => [
        'propiedad' => env('TAWK_PROPERTY_ID'),
        'widget' => env('TAWK_WIDGET_ID'),
    ],

    'agente' => [
        'clave' => env('GEMINI_API_KEY'),
        'modelo' => env('GEMINI_MODEL', 'gemini-2.5-flash'),
        'url' => 'https://generativelanguage.googleapis.com/v1beta/models',
    ],

];
