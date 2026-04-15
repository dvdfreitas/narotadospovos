<?php

declare(strict_types=1);

namespace App\Support;

final class Money
{
    /**
     * Converte strings monetárias em cêntimos (int), sem floats.
     *
     * Aceita:
     * - "5", "5.0", "5.00"
     * - "5,00"
     * - "1.234,56" (formato PT com separador de milhar)
     * Rejeita qualquer formato ambíguo/inesperado.
     */
    public static function toCents(?string $value): ?int
    {
        if ($value === null) {
            return null;
        }

        $v = trim($value);
        if ($v === '') {
            return null;
        }

        // Remover símbolos e espaços comuns
        $v = str_replace(['€', 'EUR', ' '], '', $v);

        // Se houver vírgula, assumimos formato PT: "." como milhar e "," como decimal
        if (str_contains($v, ',')) {
            $v = str_replace('.', '', $v);
            $v = str_replace(',', '.', $v);
        }

        // Validar: apenas dígitos + decimal opcional (1-2 casas)
        if (! preg_match('/^\d+(\.\d{1,2})?$/', $v)) {
            return null;
        }

        [$intPart, $decPart] = array_pad(explode('.', $v, 2), 2, '0');

        // Normalizar para 2 casas decimais
        $decPart = substr($decPart, 0, 2);
        $decPart = str_pad($decPart, 2, '0');

        return ((int) $intPart * 100) + (int) $decPart;
    }
}
