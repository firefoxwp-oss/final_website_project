<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/** Mensaje que un visitante envía desde el formulario de contacto del sitio. */
class MensajeContacto extends Mailable
{
    /**
     * @param  array{nombre: string, correo: string, asunto: string, mensaje: string}  $datos
     */
    public function __construct(public array $datos) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address($this->datos['correo'], $this->datos['nombre'])],
            subject: 'Contacto desde el sitio web: '.$this->datos['asunto'],
        );
    }

    public function content(): Content
    {
        return new Content(text: 'correos.contacto');
    }
}
