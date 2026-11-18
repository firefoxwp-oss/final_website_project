<?php

namespace Tests\Feature;

use App\Mail\MensajeContacto;
use App\Services\AgenteInteligente;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SitioTest extends TestCase
{
    public function test_la_pagina_muestra_las_secciones_pedidas(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Productos')
            ->assertSee('Separador de Contenido de Videos (Karaoke)')
            ->assertSee('Planes')
            ->assertSee('Premium')
            ->assertSee('Descargas')
            ->assertSee('/descargas/karaoke-v1.2.0.apk')
            ->assertSee('Preguntas frecuentes')
            ->assertSee('Contacto')
            ->assertSee('Asistente SoftTech');
    }

    public function test_los_terminos_y_la_privacidad_estan_publicados(): void
    {
        $this->get('/')->assertSee(route('legal').'#terminos', false)->assertSee(route('legal').'#privacidad', false);
        $this->get('/legal')
            ->assertOk()
            ->assertSee('Términos y condiciones')
            ->assertSee('Política de privacidad')
            ->assertSee('3 canciones al mes');
    }

    public function test_el_chat_solo_se_carga_si_esta_configurado(): void
    {
        config(['softtech.tawk' => ['propiedad' => null, 'widget' => null]]);
        $this->get('/')->assertDontSee('embed.tawk.to');

        config(['softtech.tawk' => ['propiedad' => 'abc123', 'widget' => 'default']]);
        $this->get('/')->assertSee('https://embed.tawk.to/abc123/default', false);
    }

    public function test_el_formulario_envia_el_correo_a_la_empresa(): void
    {
        Mail::fake();

        $this->post('/contacto', [
            'nombre' => 'Ana',
            'correo' => 'ana@correo.com',
            'asunto' => 'Consulta',
            'mensaje' => '¿Tienen versión para iOS?',
        ])->assertRedirect(url('/').'#contacto')->assertSessionHas('enviado');

        Mail::assertSent(MensajeContacto::class, fn ($correo) => $correo->hasTo(config('softtech.empresa.correo_destino'))
            && $correo->hasReplyTo('ana@correo.com'));
    }

    public function test_el_formulario_valida_los_campos(): void
    {
        Mail::fake();

        $this->post('/contacto', ['nombre' => '', 'correo' => 'no-es-correo'])
            ->assertSessionHasErrors(['nombre', 'correo', 'asunto', 'mensaje']);

        Mail::assertNothingSent();
    }

    public function test_el_agente_responde_con_gemini_y_los_datos_de_la_empresa(): void
    {
        config(['softtech.agente.clave' => 'clave-de-prueba']);
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [['content' => ['parts' => [['text' => 'Puedes subir videos MP4 de hasta 1 GB.']]]]],
        ])]);

        $this->postJson('/agente', ['mensaje' => '¿Qué puedo subir?'])
            ->assertOk()
            ->assertJson(['respuesta' => 'Puedes subir videos MP4 de hasta 1 GB.']);

        Http::assertSent(fn ($peticion) => $peticion->hasHeader('x-goog-api-key', 'clave-de-prueba')
            && str_contains($peticion['system_instruction']['parts'][0]['text'], 'SoftTech'));
    }

    public function test_sin_gemini_el_agente_responde_con_las_preguntas_frecuentes(): void
    {
        config(['softtech.agente.clave' => null]);

        $this->postJson('/agente', ['mensaje' => '¿Cuánto tarda en procesarse una canción?'])
            ->assertOk()
            ->assertJsonPath('respuesta', config('softtech.preguntas.1.respuesta'));

        $this->postJson('/agente', ['mensaje' => '¿Quién ganó el partido de ayer?'])
            ->assertJsonPath('respuesta', AgenteInteligente::SIN_RESPUESTA);
    }

    public function test_si_gemini_falla_el_agente_usa_el_respaldo(): void
    {
        config(['softtech.agente.clave' => 'clave-de-prueba']);
        Http::fake(['generativelanguage.googleapis.com/*' => Http::response(['error' => 'cuota'], 429)]);

        $this->postJson('/agente', ['mensaje' => '¿Dónde se guardan mis grabaciones?'])
            ->assertOk()
            ->assertJsonPath('respuesta', config('softtech.preguntas.6.respuesta'));
    }
}
