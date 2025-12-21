<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class IfThenPayCallbackController extends Controller
{
    public function handle(Request $request): Response
    {
        /**
         * Registo inicial do callback.
         * O IP e o payload completo são guardados para auditoria e debugging,
         * independentemente de o callback ser aceite ou rejeitado.
         */
        $callbackIp = $request->ip();

        Log::info('IfthenPay callback received', [
            'ip'      => $callbackIp,
            'payload' => $request->all(),
        ]);

        /**
         * Validação opcional da antiphishing key.
         * Se a key estiver configurada, o callback só é aceite
         * se a chave recebida corresponder exatamente.
         */
        $expectedKey = config('services.ifthenpay.antiphishing_key');

        if ($expectedKey !== null) {
            $receivedKey = $request->input('chave');

            if ($expectedKey !== $receivedKey) {
                Log::warning('IfthenPay callback with invalid antiphishing key');

                return response('Invalid key', 403);
            }
        }

        /**
         * Identificação do pagamento interno através do order_id.
         * O order_id é a ligação entre o pedido inicial e o callback.
         */
        $orderId = $request->input('referencia');

        $payment = Payment::where('order_id', $orderId)->first();

        if (! $payment) {
            Log::error('IfthenPay callback: payment not found', [
                'order_id' => $orderId,
            ]);

            return response('Payment not found', 404);
        }

        /**
         * Verificação do método de pagamento.
         * Este callback só pode processar pagamentos MB Way.
         */
        if ($payment->method !== Payment::METHOD_MBWAY) {
            Log::error('IfthenPay callback method mismatch', [
                'payment_id' => $payment->id,
                'method'     => $payment->method,
            ]);

            return response('Invalid payment method', 400);
        }

        /**
         * Idempotência total.
         * Se o pagamento já estiver num estado final, o callback é ignorado.
         */
        if (in_array($payment->status, [
            Payment::STATUS_PAID,
            Payment::STATUS_REJECTED,
        ], true)) {
            Log::info('IfthenPay callback ignored (final state)', [
                'payment_id' => $payment->id,
                'status'     => $payment->status,
            ]);

            return response('Already finalized', 200);
        }

        /**
         * Persistência dos dados crus do fornecedor.
         * Estes dados são guardados independentemente do resultado final.
         */
        $payment->update([
            'provider_status'  => $request->input('estado'),
            'provider_message' => $request->input('mensagem'),
        ]);

        /**
         * Validação de integridade do valor.
         * O valor confirmado no callback tem de coincidir com o valor esperado.
         */
        $callbackAmount = (float) $request->input('valor');
        $expectedAmount = (float) $payment->amount;

        if ($callbackAmount !== $expectedAmount) {
            Log::error('IfthenPay callback amount mismatch', [
                'order_id'        => $payment->order_id,
                'expected_amount' => $expectedAmount,
                'callback_amount' => $callbackAmount,
            ]);

            return response('Amount mismatch', 400);
        }

        /**
         * Atualização do estado interno do pagamento.
         * Um pagamento só é marcado como pago após confirmação explícita
         * e validação completa do callback.
         */
        if ($request->input('estado') === '000') {
            $payment->markAsPaid();
        } else {
            $payment->markAsRejected();
        }

        /**
         * Log final que indica que o callback foi processado com sucesso.
         */
        Log::info('IfthenPay callback processed', [
            'payment_id' => $payment->id,
            'status'     => $payment->status,
        ]);

        return response('OK', 200);
    }
}
