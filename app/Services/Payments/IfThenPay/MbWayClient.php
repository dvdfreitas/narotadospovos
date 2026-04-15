<?php

namespace App\Services\Payments\IfThenPay;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MbWayClient
{
    private const ENDPOINT = 'https://api.ifthenpay.com/spg/payment/mbway';

    protected string $mbWayKey;

    /**
     * @param string|null $mbWayKey The anti-phishing key. If null, loads from config.
     */
    public function __construct(?string $mbWayKey = null)
    {
        // If the key is passed manually, use it. Otherwise, fetch from config.
        $this->mbWayKey = $mbWayKey ?? config('services.ifthenpay.mbway_key');
    }
    /**
     * Initiates a payment request to the MB WAY API.
     *
     * @param string $phoneNumber The donor's phone number (can be raw 91xxxxxxx or with prefix).
     * @param string $amount The amount to charge (e.g., "10.50").
     * @param string $orderId The unique identifier for this order/donation.
     * @param string $email The donor's email for notifications.
     * @param string $description A short description for the payment.
     * @return MbWayPaymentResult
     * @throws \Exception If the HTTP request fails entirely.
     */
    public function initPayment(
        string $phoneNumber,
        string $amount,
        string $orderId,
        string $email,
        string $description
    ): MbWayPaymentResult {
        // Ensure format 351#9xxxxxxxxx as required by IfThenPay
        $formattedPhone = $this->formatPhoneNumber($phoneNumber);

        // Prepare the payload based on API docs
        $payload = [
            'mbWayKey' => $this->mbWayKey,
            'orderId' => $orderId,
            'amount' => $amount,
            'mobileNumber' => $formattedPhone,
            'email' => $email,
            'description' => $description,
        ];

        try {
            $response = Http::post(self::ENDPOINT, $payload);
            $data = $response->json();

            // Log payload for debugging (exclude sensitive keys in production if necessary)
            Log::info('IfThenPay MBWAY Request', ['payload' => $payload, 'response' => $data]);

            return new MbWayPaymentResult(
                requestId: $data['RequestId'] ?? '',
                status: $data['Status'] ?? 'ERR',
                message: $data['Message'] ?? 'Unknown error occurred'
            );
        } catch (\Throwable $e) {
            Log::error('IfThenPay MBWAY Connection Error', ['error' => $e->getMessage()]);

            // Return a generic error result so the app doesn't crash
            return new MbWayPaymentResult(
                requestId: '',
                status: 'ERR',
                message: 'Communication error with payment gateway.'
            );
        }
    }

    /**
     * Helper to ensure the phone number has the correct prefix for the API (351#).
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove non-numeric characters first
        $clean = preg_replace('/\D/', '', $phone);

        // If it already starts with 351, we just add the #
        // This is a simplified logic; adjust if you expect international numbers.
        if (!str_starts_with($clean, '351')) {
            return "351#{$clean}";
        }

        return "351#" . substr($clean, 3);
    }
}
