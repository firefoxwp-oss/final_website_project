<?php

namespace App\Http\Controllers;

use App\Mail\MensajeContacto;
use App\Services\AgenteInteligente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Throwable;

class SitioController extends Controller
{
    /** Términos y condiciones y política de privacidad que se aceptan al crear la cuenta. */
    public function legal(): View
    {
        return view('legal', ['empresa' => config('softtech.empresa'), 'producto' => config('softtech.producto')]);
    }

    public function inicio(): View
    {
        $descargas = config('softtech.descargas');
        $url = rtrim($descargas['url_base'], '/');
        $versiones = array_map(fn ($v) => $v + ['url' => "{$url}/{$v['archivo']}"], $descargas['versiones']);

        return view('sitio', [
            'empresa' => config('softtech.empresa'),
            'producto' => config('softtech.producto'),
            'planes' => config('softtech.planes'),
            'comoPremium' => config('softtech.como_premium'),
            'versiones' => $versiones,
            'preguntas' => config('softtech.preguntas'),
            'tawk' => config('softtech.tawk'),
        ]);
    }

    public function contacto(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|max:150',
            'asunto' => 'required|string|max:150',
            'mensaje' => 'required|string|max:3000',
        ], [
            'required' => 'Este campo es obligatorio.',
            'email' => 'Escribe un correo electrónico válido.',
            'max' => 'El texto es demasiado largo.',
        ]);

        try {
            Mail::to(config('softtech.empresa.correo_destino'))->send(new MensajeContacto($datos));
        } catch (Throwable $e) {
            Log::error('Contacto: no se pudo enviar el correo', ['error' => $e->getMessage()]);

            return redirect()->to(url('/').'#contacto')->withInput()
                ->with('error', 'No se pudo enviar tu mensaje. Inténtalo de nuevo o escríbenos por el chat.');
        }

        return redirect()->to(url('/').'#contacto')
            ->with('enviado', 'Gracias por escribirnos. Te responderemos a tu correo lo antes posible.');
    }

    public function agente(Request $request, AgenteInteligente $agente): JsonResponse
    {
        $datos = $request->validate([
            'mensaje' => 'required|string|max:500',
            'historial' => 'array|max:10',
            'historial.*.rol' => 'required|in:usuario,asistente',
            'historial.*.texto' => 'required|string|max:1500',
        ]);

        return response()->json([
            'respuesta' => $agente->responder($datos['mensaje'], $datos['historial'] ?? []),
        ]);
    }
}
