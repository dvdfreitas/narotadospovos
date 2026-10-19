<?php

namespace App\Services\IfThenPay;

use UnexpectedValueException;

/**
 * A resposta da ifthenpay a um pedido de pagamento, com nomes nossos.
 *
 * Guarda os três campos de que dependemos. O orderId e o amount que a resposta
 * também traz são os que nós enviámos — não há razão para uma segunda cópia.
 *
 * O resultado de uma consulta de estado é outra classe: o mesmo código "000"
 * significa coisas diferentes nos dois momentos.
 *
 * Referência dos campos: documentation/ifthenpay.md
 */
final class MbWayRequestResult
{
    /**
     * "Request initialized successfully (pending acceptance)" — a ifthenpay
     * aceitou o pedido e o telemóvel do cliente tocou. Ninguém pagou ainda.
     */
    private const STATUS_ACCEPTED = '000';

    public function __construct(
        public readonly string $status,
        public readonly string $message,
        public readonly ?string $requestId,
    ) {}

    /**
     * Constrói a partir do corpo JSON devolvido pela API.
     *
     * Status rebenta se faltar: é o campo de que tudo depende, e a mensagem
     * leva o corpo completo para se ver o que chegou.
     * Message pode vir vazio — serve para diagnóstico e não decide nada.
     * RequestId pode vir nulo: com Status 100 ou 999 não há pedido criado.
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            status: $data['Status'] ?? throw new UnexpectedValueException(
                'Resposta MB Way sem Status: ' . json_encode($data)
            ),
            message: $data['Message'] ?? '',
            requestId: $data['RequestId'] ?? null,
        );
    }

    public function wasAccepted(): bool
    {
        return $this->status === self::STATUS_ACCEPTED;
    }
}
