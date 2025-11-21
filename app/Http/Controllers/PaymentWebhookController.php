<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class PaymentWebhookController extends Controller
{
    public function handleMbway(Request $request)
    {
        // URL Exemplo que eles chamam:
        // site.com/api/payments/mbway/callback?chave=XXX&referencia=123&valor=10.00&estado=PAGA

        // 1. Segurança: Verificar a chave Anti-Phishing (definida por ti no Backoffice da Ifthenpay)
        $mySecurityKey = config('services.ifthenpay.callback_key');

        if ($request->input('chave') !== $mySecurityKey) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // 2. Obter dados
        $donationId = $request->input('referencia'); // O ID que enviámos antes
        $status = $request->input('estado'); // 'PAGA'

        // 3. Atualizar a Base de Dados
        if ($status === 'PAGA') {
            $donation = Donation::find($donationId);

            if ($donation && $donation->payment_status !== 'paid') {
                $donation->update([
                    'payment_status' => 'paid',
                    'updated_at' => now(),
                ]);

                // EXTRA: Se for PRENDA, é aqui que disparas o envio do Email
                // if ($donation->is_gift) { ... Mail::to(...)->send(...) ... }
            }
        }

        return response()->json(['message' => 'OK']);
    }
}
