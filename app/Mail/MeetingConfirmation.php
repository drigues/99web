<?php

namespace App\Mail;

use App\Models\MeetingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MeetingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly MeetingRequest $meeting) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Reunião confirmada — 99web',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.meeting-confirmation',
        );
    }
}
