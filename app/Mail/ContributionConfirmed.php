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

/**
 * Agradece e confirma um contributo pago.
 *
 * ShouldQueue: o envio não acontece dentro do pedido que o despoletou. A
 * notificação da ifthenpay responde depressa, e um servidor de email lento
 * nunca pode fazer com que a entrega seja dada por falhada.
 *
 * Um email que não sai não pode desfazer um pagamento que entrou.
 */
class ContributionConfirmed extends Mailable implements ShouldQueue
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
            subject: "Obrigado pelo seu contributo — {$this->order->access_code}",
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.contribution-confirmed');
    }
}
