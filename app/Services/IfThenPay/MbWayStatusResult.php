<?php

namespace App\Services\IfThenPay;

use UnexpectedValueException;

/**
 * A resposta da ifthenpay a uma consulta de estado, com nomes nossos.
 *
 * Classe distinta do MbWayRequestResult porque o mesmo código significa
 * coisas diferentes: aqui "000" quer dizer pago; no pedido quer dizer que
 * a notificação chegou ao telemóvel.
 *
 * Referência dos códigos: documentation/ifthenpay.md
 */
final class MbWayStatusResult
{
    private const STATUS_PAID     = '000';
    private const STATUS_REJECTED = '020';
    private const STATUS_EXPIRED  = '101';
    private const STATUS_DECLINED = '122';

    public function __construct(
        public readonly string $status,
        public readonly string $message,
    ) {}

    /**
     * Constrói a partir do corpo JSON devolvido pela consulta.
     *
     * Não guarda o requestId: viria de volta, mas foi o que nós enviámos
     * para perguntar — já o temos.
     */
    public static function fromResponse(array $data): self
    {
        return new self(
            status: $data['Status'] ?? throw new UnexpectedValueException(
                'Consulta de estado MB Way sem Status: ' . json_encode($data)
            ),
            message: $data['Message'] ?? '',
        );
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    /**
     * Cobre os dois códigos de recusa: 020 é o cliente a recusar na app,
     * 122 é a recusa apresentada ao cliente (saldo, limite). Do nosso lado
     * a distinção não muda nada — em ambos não entrou dinheiro.
     */
    public function isRejected(): bool
    {
        return in_array($this->status, [self::STATUS_REJECTED, self::STATUS_DECLINED]);
    }

    /**
     * Expirado não é recusado: ninguém disse que não, o cliente apenas não
     * chegou a tempo. A distinção muda o que se lhe diz no ecrã — expirar
     * convida a tentar de novo, recusar não.
     */
    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
    }
}
