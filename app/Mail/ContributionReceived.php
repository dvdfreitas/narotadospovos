<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContributionReceived extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly Order $order,
        public readonly Payment $payment,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Novo contributo pago — {$this->order->access_code}",
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.contribution-received');
    }
}
