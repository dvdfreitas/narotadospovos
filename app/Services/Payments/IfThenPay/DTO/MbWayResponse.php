<?php

namespace App\Services\Payments\IfThenPay\DTO;

use RuntimeException;

final class MbWayResponse
{
    public readonly string $status;
    public readonly string $requestId;
    public readonly string $message;

    private function __construct(
        string $status,
        string $requestId,
        string $message
    ) {
        $this->status    = $status;
        $this->requestId = $requestId;
        $this->message   = $message;
    }

    /**
     * Factory method to build DTO from IfthenPay API response.
     */
    public static function fromApi(array $data): self
    {
        if (!isset($data['Estado'])) {
            throw new RuntimeException('Invalid MB Way response: missing Estado.');
        }

        return new self(
            status: (string) $data['Estado'],
            requestId: (string) ($data['IdPedido'] ?? ''),
            message: (string) ($data['MsgDescricao'] ?? '')
        );
    }

    /**
     * Business-friendly helpers
     */
    public function isSuccess(): bool
    {
        return $this->status === '000';
    }

    public function isPending(): bool
    {
        return in_array($this->status, ['100', '122'], true);
    }

    public function isRejected(): bool
    {
        return ! $this->isSuccess() && ! $this->isPending();
    }
}
