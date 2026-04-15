<?php

namespace App\Services\Payments\IfThenPay;

class MbWayPaymentResult
{
    /**
     * @param string $requestId The internal request ID from IfThenPay.
     * @param string $status The status code (e.g., "000" for success, "999" for error).
     * @param string $message The human-readable message from the API.
     */
    public function __construct(
        public readonly string $requestId,
        public readonly string $status,
        public readonly string $message,
    ) {}

    /**
     * Checks if the payment request was successfully initiated (Status "000").
     * Note: This means the notification was sent to the user's phone, not that it is paid yet.
     */
    public function isAccepted(): bool
    {
        return $this->status === '000';
    }
}