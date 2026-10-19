<?php

namespace App\Services\Payments;

use App\Models\Payment;
use App\Services\IfThenPay\MbWayClient;
use App\Services\IfThenPay\MbWayUnavailableException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Arranca um pagamento MB Way para qualquer coisa pagável.
 *
 * Trata dos nossos modelos, estados e transações. Quem fala com a ifthenpay
 * é o MbWayClient, que esta classe recebe já construído e com a chave lá
 * dentro — daqui não se sabe sequer que existe uma chave.
 *
 * Desenho e estados: documentation/mbway-plan.md
 */
class StartMbWayPayment
{
    public function __construct(
        private readonly MbWayClient $client,
    ) {}

    /**
     * O valor vem por fora porque cada pagável lhe chama outra coisa:
     * Order tem total, Donation tem amount. Recebendo-o como argumento,
     * esta classe mantém-se cega ao tipo que está a pagar.
     *
     * Devolve sempre o Payment, qualquer que tenha sido o desfecho. Quem
     * chama lê o status para saber o que mostrar ao comprador.
     */
    public function start(
        Model $payable,
        string $amount,
        string $mobileNumber,
        string $description,
    ): Payment {
        // Gravar antes de chamar a API: se a chamada falhar, fica prova de
        // que tentámos e uma referência para a notificação encontrar.
        //
        // A transação fecha a janela entre a linha existir e ter referência:
        // ou as duas escritas acontecem, ou nenhuma fica.
        //
        // Criado pela relação, não por Payment::create(): assim payable_type
        // e payable_id preenchem-se sozinhos, sem hipótese de os trocar.
        $payment = DB::transaction(function () use ($payable, $amount) {
            $payment = $payable->payments()->create([
                'method' => 'mbway',
                'amount' => $amount,
                'status' => Payment::STATUS_PENDING,
            ]);

            $payment->assignReference();

            return $payment;
        });

        // Sem variável no catch: o que importa é que houve falha de ligação,
        // não qual foi. A causa fica encadeada no log.
        //
        // unknown é o único estado que não afirma nada: o pedido pode ter
        // sido criado e o telemóvel ter tocado. Nunca dizer que falhou.
        try {
            $resultado = $this->client->requestPayment(
                orderId: $payment->reference,
                amount: $amount,
                mobileNumber: $mobileNumber,
                description: $description,
            );
        } catch (MbWayUnavailableException) {
            $payment->markAsUnknown();

            return $payment;
        }

        // Os 4 minutos vêm da documentação da ifthenpay, não de estimativa.
        $resultado->wasAccepted()
            ? $payment->markAsRequested($resultado->requestId, now()->addMinutes(4))
            : $payment->markAsFailed();

        return $payment;
    }
}
