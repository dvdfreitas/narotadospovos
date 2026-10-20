<?php

namespace App\Services\Payments;

use App\Mail\ContributionConfirmed;
use App\Models\Order;
use App\Models\Payment;
use App\Services\IfThenPay\MbWayClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Pergunta à ifthenpay o que aconteceu a um pagamento e aplica o resultado.
 *
 * Existe porque três sítios precisam da mesma regra: o ecrã de espera, o job
 * de polling e o controlador da notificação. Sem isto, a tradução entre os
 * códigos deles e os nossos estados ficava escrita três vezes.
 *
 * Códigos e significados: documentation/ifthenpay.md
 */
class CheckMbWayPayment
{
    public function __construct(
        private readonly MbWayClient $client,
    ) {}

    /**
     * Sem try/catch de propósito: se a ifthenpay não responder, a
     * MbWayUnavailableException sobe para quem chamou. O ecrã de espera
     * ignora e pergunta daqui a pouco, o job tenta no ciclo seguinte, e o
     * controlador da notificação devolve erro — já guardou o corpo cru.
     * Apanhá-la aqui obrigava os três ao mesmo comportamento.
     */
    public function check(Payment $payment): Payment
    {
        // Já resolvido, ou sem identificador para consultar. O segundo é o
        // caso do unknown: o timeout deixou-nos sem RequestId, e só a
        // notificação ou a reconciliação o recuperam.
        if ($payment->isFinal() || $payment->provider_request_id === null) {
            return $payment;
        }

        $status = $this->client->checkStatus($payment->provider_request_id);

        $payment->update([
            'provider_status'  => $status->status,
            'provider_message' => $status->message,
        ]);

        // Sem default a adivinhar: um código desconhecido deixa o pagamento
        // onde está, para ser consultado de novo mais tarde.
        match (true) {
            $status->isPaid()     => $this->confirm($payment),
            $status->isRejected() => $payment->markAsRejected(),
            $status->isExpired()  => $payment->markAsExpired(),
            default               => null,
        };

        return $payment;
    }

    /**
     * Marca como pago e agradece.
     *
     * O email vai para a fila, por isso esta chamada não espera pelo servidor
     * de email. Ainda assim fica protegida: se a fila estiver mal configurada
     * ou o Mailable rebentar ao ser serializado, o pagamento continua pago e
     * o erro fica no log.
     *
     * Um email que não sai não pode desfazer um pagamento que entrou.
     */
    private function confirm(Payment $payment): void
    {
        $payment->markAsPaid();

        $payable = $payment->payable;

        if (! $payable instanceof Order) {
            return;
        }

        try {
            Mail::to($payable->buyer_email)
                ->send(new ContributionConfirmed($payable, $payment->fresh()));
        } catch (\Throwable $e) {
            Log::error('Falha ao enviar confirmação de contributo', [
                'payment_id' => $payment->id,
                'reference'  => $payment->reference,
                'erro'       => $e->getMessage(),
            ]);
        }
    }
}
