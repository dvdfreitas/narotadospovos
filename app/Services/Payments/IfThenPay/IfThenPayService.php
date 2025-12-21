<?php

namespace App\Services\Payments\IfThenPay;

use App\Services\Payments\IfThenPay\DTO\MbWayResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class IfThenPayService
{
    public const CODE_SUCCESS = '000';
    public const CODE_ERROR   = '999';

    protected string $mbwayKey;
    protected string $endpoint;
    protected bool $isTest;

    public function __construct()
    {
        $this->mbwayKey = config('services.ifthenpay.mbway.key');
        $this->endpoint = config('services.ifthenpay.endpoints.mbway');
        $this->isTest   = config('services.ifthenpay.env') === 'test';

        if (empty($this->mbwayKey)) {
            throw new RuntimeException('IfthenPay MBWay key is not configured.');
        }

        if (empty($this->endpoint)) {
            throw new RuntimeException('IfthenPay MBWay endpoint is not configured.');
        }
    }

    /**
     * Request an MB Way payment.
     *
     * @param string $phone
     * @param float  $amount
     * @param string $orderId
     * @param string $description
     *
     * @return array
     */
    public function requestMbWayPayment(
        string $phone,
        float $amount,
        string $orderId,
        string $description = 'Test Payment'
    ): MbWayResponse {
        if ($this->isTest) {
            return $this->simulatePayment($orderId);
        }

        return $this->callApi($phone, $amount, $orderId, $description);
    }

    /**
     * Real API call to IfthenPay MB Way endpoint.
     */
    protected function callApi(
        string $phone,
        float $amount,
        string $orderId,
        string $description
    ): MbWayResponse {
        try {
            $response = Http::timeout(10)
                ->retry(2, 100)
                ->post($this->endpoint, [
                    'MbWayKey'   => $this->mbwayKey,
                    'canal'      => '03',
                    'referencia' => $orderId,
                    'valor'      => number_format($amount, 2, '.', ''),
                    'nrtlm'      => $phone,
                    'descricao'  => $description,
                ]);

            if (! $response->successful()) {
                Log::error('IfthenPay MBWay HTTP error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                throw new RuntimeException('IfthenPay MBWay request failed.');
            }

            return MbWayResponse::fromApi($response->json());
        } catch (\Throwable $e) {
            Log::error('IfthenPay MBWay exception', [
                'message' => $e->getMessage(),
            ]);

            throw new RuntimeException('IfthenPay MBWay communication error.');
        }
    }

    /**
     * Simulated MB Way payment (test environment only).
     */
    protected function simulatePayment(string $orderId): MbWayResponse
    {
        Log::info("IfthenPay TEST MODE: Simulated MB Way payment", [
            'order_id' => $orderId,
        ]);

        return MbWayResponse::fromApi([
            'Estado'        => '000',
            'IdPedido'     => 'TEST_' . $orderId,
            'MsgDescricao' => 'Simulated MB Way success',
        ]);
    }
}
