<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderItem;
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

    /**
     * $isTest marca o assunto com [Teste]: é o que o bazar:testar-email
     * envia, e quem o recebe não o pode confundir com um contributo real.
     */
    public function __construct(
        public readonly Order $order,
        public readonly Payment $payment,
        public readonly bool $isTest = false,
    ) {}

    /**
     * Um contributo inventado, para pré-visualizar e testar o envio sem
     * comprar nada. Nada disto é gravado: os modelos só existem em memória.
     */
    public static function example(bool $isTest = true): self
    {
        $order = new Order([
            'total'       => '27.50',
            'buyer_name'  => 'Maria Silva',
            'buyer_email' => 'maria@exemplo.pt',
            'tax_number'  => '123456789',
        ]);
        $order->access_code = 'EXEMPLO';

        $order->setRelation('items', collect([
            new OrderItem(['product_name' => 'Cabaz', 'variant_label' => 'Família', 'unit_price' => '12.50', 'quantity' => 1]),
            new OrderItem(['product_name' => 'Papas lácteas', 'variant_label' => '1 pacote', 'unit_price' => '3.75', 'quantity' => 4]),
        ]));

        $payment = new Payment(['confirmed_at' => now()]);

        return new self($order, $payment, $isTest);
    }

    public function envelope(): Envelope
    {
        $subject = "Obrigado pelo seu contributo — {$this->order->access_code}";

        return new Envelope(
            subject: $this->isTest ? "[Teste] {$subject}" : $subject,
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'mail.contribution-confirmed');
    }
}
