<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Payments\CheckMbWayPayment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Recebe a notificação que a ifthenpay envia quando um pagamento MB Way
 * chega a um estado final: pago, recusado ou expirado.
 *
 * A ifthenpay não escreve na nossa base de dados — faz um POST a este
 * endereço. Quem valida e decide o que gravar é este controlador.
 *
 * O pagamento é resolvido pela referência no caminho do URL, e não pelo
 * RequestId que vem no corpo: num timeout podemos nunca ter recebido o
 * RequestId, mas a referência foi sempre nossa.
 *
 * Formato e assinatura: documentation/ifthenpay.md
 */
class MbWayNotificationController extends Controller
{
    public function __construct(
        private readonly CheckMbWayPayment $check,
    ) {}

    public function __invoke(Request $request, Payment $payment): Response
    {
        // Duas das três parcelas vêm da nossa base de dados, não do corpo
        // recebido: quem forjar uma notificação com outro valor não consegue
        // produzir a assinatura, porque a conta é feita com o nosso valor.
        //
        // O cast decimal:2 garante que o amount sai sempre com duas casas.
        $assinatura = hash_hmac(
            'sha256',
            $payment->reference . $payment->amount . $request->input('RequestId'),
            config('services.ifthenpay.mbway_key'),
        );

        // hash_equals compara em tempo constante. Com === o PHP pára na
        // primeira diferença, e medindo tempos de resposta seria possível
        // descobrir a assinatura caractere a caractere.
        if (! hash_equals($assinatura, (string) $request->header('X-Ifthenpay-Signature'))) {
            abort(403);
        }

        // Já resolvido por outro caminho — tipicamente o job de polling.
        // "Já tratado" é sucesso, não falha: responder com erro só levaria
        // a ifthenpay a repetir sem necessidade.
        if ($payment->isFinal()) {
            return response('OK');
        }

        // Guardar antes de interpretar: se o passo seguinte falhar — a
        // ifthenpay fora do ar quando formos confirmar — fica registado o que
        // chegou. Não há repetições, uma notificação perdida não volta.
        //
        // O RequestId só é aceite do corpo quando não o temos. Num timeout
        // nunca chegámos a recebê-lo e é esta a única forma de o obter; mas
        // quando já o temos, mantemos o nosso: quem tivesse a chave poderia
        // enviar o identificador de outra transação realmente paga e fazer-nos
        // confirmar um pagamento que ninguém fez.
        $payment->update([
            'provider_payload'    => $request->all(),
            'provider_status'     => $request->input('Status'),
            'provider_message'    => $request->input('Message'),
            'provider_request_id' => $payment->provider_request_id
                ?? $request->input('RequestId'),
        ]);

        // A decisão não vem da notificação. Ela trouxe um Status, que ficou
        // guardado em provider_status e é ignorado para decidir. A verdade vem
        // de uma consulta nossa ao /mbway/status, que ninguém de fora forja.
        $this->check->check($payment);

        return response('OK');
    }
}
