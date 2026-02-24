<?php

namespace App\Mail;

use App\Models\PackageRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PackageRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly PackageRequest $packageRequest,
        public readonly array $packageData,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[99web] Novo pedido de pacote: ' . $this->packageData['name'] . ' — ' . $this->packageRequest->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.package-request-notification',
        );
    }
}
