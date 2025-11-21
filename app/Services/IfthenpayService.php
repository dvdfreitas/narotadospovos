<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Importante para registar a simulação

class IfthenpayService
{
    protected $mbwayKey;

    public function __construct()
    {
        $this->mbwayKey = config('services.ifthenpay.mbway_key');
    }

    /**
     * Envia o pedido de pagamento para o telemóvel do utilizador
     */
    public function requestMbWayPayment($phone, $amount, $donationId)
    {
        // ============================================================
        // 1. BLOCO DE SIMULAÇÃO (O que faltava)
        // ============================================================
        // Se a chave for 'TESTE' ou estiver vazia, fingimos que deu certo.
        if ($this->mbwayKey === 'TESTE' || empty($this->mbwayKey)) {

            Log::info("SIMULAÇÃO MBWAY: Pedido aceite para $phone ($amount €)");

            return [
                'Estado' => '000', // Código oficial de sucesso da Ifthenpay
                'IdPedido' => 'SIMULACAO_' . uniqid(),
                'MsgDescricao' => 'Sucesso Simulado (Modo Teste)'
            ];
        }

        // ============================================================
        // 2. PEDIDO REAL (Só acontece em Produção)
        // ============================================================
        $url = 'https://mbway.ifthenpay.com/IfthenPayMBW.asmx/SetPedidoJSON';

        try {
            $response = Http::post($url, [
                'MbWayKey' => $this->mbwayKey,
                'canal' => '03',
                'referencia' => (string) $donationId,
                'valor' => number_format($amount, 2, '.', ''),
                'nrtlm' => $phone,
                'email' => '',
                'descricao' => 'Arvore Natal Solidaria',
            ]);

            return $response->json();

        } catch (\Exception $e) {
            Log::error("Erro Ifthenpay: " . $e->getMessage());
            return [
                'Estado' => '999',
                'MsgDescricao' => 'Erro de comunicação com a gateway.'
            ];
        }
    }
}
