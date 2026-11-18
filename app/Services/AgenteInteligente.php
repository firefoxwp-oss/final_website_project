<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

/**
 * Asistente virtual del sitio. Responde con Gemini usando solo la información
 * de SoftTech; si Gemini no está configurado o no responde, busca la
 * respuesta en las preguntas frecuentes.
 */
class AgenteInteligente
{
    public const SIN_RESPUESTA = 'No tengo esa información. Puedes escribirnos desde el formulario de contacto '
        .'o hablar con nuestro equipo en el chat.';

    /**
     * @param  array<int, array{rol: string, texto: string}>  $historial
     */
    public function responder(string $mensaje, array $historial = []): string
    {
        if (config('softtech.agente.clave')) {
            try {
                $respuesta = $this->consultarGemini($mensaje, $historial);
                if ($respuesta !== '') {
                    return $respuesta;
                }
            } catch (Throwable $e) {
                Log::warning('Agente: Gemini no respondió', ['error' => $e->getMessage()]);
            }
        }

        return $this->buscarEnPreguntas($mensaje);
    }

    private function consultarGemini(string $mensaje, array $historial): string
    {
        $contenidos = [];
        foreach ($historial as $turno) {
            $contenidos[] = [
                'role' => $turno['rol'] === 'asistente' ? 'model' : 'user',
                'parts' => [['text' => $turno['texto']]],
            ];
        }
        $contenidos[] = ['role' => 'user', 'parts' => [['text' => $mensaje]]];

        $url = config('softtech.agente.url').'/'.config('softtech.agente.modelo').':generateContent';
        $respuesta = Http::withHeaders(['x-goog-api-key' => config('softtech.agente.clave')])
            ->timeout(20)
            ->post($url, [
                'system_instruction' => ['parts' => [['text' => $this->instrucciones()]]],
                'contents' => $contenidos,
                'generationConfig' => ['temperature' => 0.3, 'maxOutputTokens' => 400],
            ])
            ->throw();

        $partes = $respuesta->json('candidates.0.content.parts', []);

        return trim(implode('', array_column($partes, 'text')));
    }

    /** Instrucciones del agente con toda la información pública de la empresa. */
    public function instrucciones(): string
    {
        $c = config('softtech');
        $texto = "Eres el asistente virtual del sitio web de {$c['empresa']['nombre']}. Responde en español, en pocas "
            .'oraciones y con un tono amable, usando solo la información de este texto. Si te preguntan algo que no '
            .'está aquí o que no tiene relación con SoftTech o su producto, responde exactamente: "'.self::SIN_RESPUESTA
            ."\". No inventes precios, fechas ni funciones.\n\n";
        $texto .= "EMPRESA: {$c['empresa']['descripcion']} Ciudad: {$c['empresa']['ciudad']}. Correo: "
            ."{$c['empresa']['correo']}. Horario de atención: {$c['empresa']['horario']}.\n\n";
        $texto .= "PRODUCTO: {$c['producto']['nombre']}. {$c['producto']['resumen']}\nCaracterísticas:\n- "
            .implode("\n- ", $c['producto']['caracteristicas'])."\nPlataformas: "
            .implode('; ', array_map(fn ($p) => "{$p['nombre']}: {$p['detalle']}", $c['producto']['plataformas']))
            ."\n\nPLANES:\n";
        foreach ($c['planes'] as $plan) {
            $texto .= "- {$plan['nombre']} ({$plan['precio']} {$plan['periodo']}): ".implode(' ', $plan['beneficios'])."\n";
        }
        $texto .= $c['como_premium']."\n\nDESCARGAS (aplicación móvil Android, sección Descargas del sitio):\n";
        foreach ($c['descargas']['versiones'] as $v) {
            $texto .= "- Versión {$v['version']} ({$v['fecha']}): ".implode(' ', $v['cambios'])."\n";
        }
        $texto .= "\nPREGUNTAS FRECUENTES:\n";
        foreach ($c['preguntas'] as $p) {
            $texto .= "P: {$p['pregunta']}\nR: {$p['respuesta']}\n";
        }

        return $texto;
    }

    /** Respuesta de respaldo: la pregunta frecuente que comparte más palabras con el mensaje. */
    private function buscarEnPreguntas(string $mensaje): string
    {
        $palabras = $this->palabras($mensaje);
        $mejor = null;
        $puntaje = 0;
        foreach (config('softtech.preguntas') as $p) {
            $comunes = count(array_intersect($palabras, $this->palabras($p['pregunta'].' '.$p['respuesta'])));
            if ($comunes > $puntaje) {
                [$mejor, $puntaje] = [$p, $comunes];
            }
        }

        return $mejor && $puntaje >= 2 ? $mejor['respuesta'] : self::SIN_RESPUESTA;
    }

    /** @return array<int, string> */
    private function palabras(string $texto): array
    {
        $vacias = ['como', 'cual', 'para', 'puedo', 'esta', 'este', 'donde', 'cuando', 'que', 'una', 'las', 'los', 'del',
            'con', 'por', 'mis', 'tus', 'sus', 'hay', 'hace', 'tiene', 'desde'];
        $limpio = Str::of(Str::ascii(mb_strtolower($texto)))->replaceMatches('/[^a-z0-9 ]/', ' ');

        return array_values(array_unique(array_filter(
            explode(' ', (string) $limpio),
            fn ($p) => strlen($p) > 3 && ! in_array($p, $vacias, true)
        )));
    }
}
