<?php

namespace App\Mail;

use App\Models\PackageRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PackageRequestConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly PackageRequest $packageRequest,
        public readonly array $packageData,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Recebemos o seu pedido — 99web',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.package-request-confirmation',
        );
    }
}
