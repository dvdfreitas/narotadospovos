<?php

namespace App\Services\IfThenPay;

use RuntimeException;

/**
 * Não foi possível falar com a ifthenpay: timeout, DNS, servidor em baixo.
 *
 * Tipo próprio para que quem chama possa apanhar exactamente este caso sem
 * apanhar bugs de programação à boleia.
 *
 * Quem a apanhar não sabe se o pedido chegou a ser criado — o telemóvel do
 * cliente pode ter tocado. Nunca dizer ao comprador que o pagamento falhou.
 */
class MbWayUnavailableException extends RuntimeException
{
}
