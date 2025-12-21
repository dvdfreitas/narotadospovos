<?php

namespace App\Enums;

enum DonationStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';       // Substitui o 'Confirmed'
    case Failed = 'failed';   // Essencial para erros de pagamento
    case Cancelled = 'cancelled';
    
    // Opcional: Para mostrar no admin panel em Português
    public function labelPt(): string
    {
        return match ($this) {
            self::Pending => 'Pendente',
            self::Paid => 'Pago',
            self::Failed => 'Falhou',
            self::Cancelled => 'Cancelado',
        };
    }
    
    // Helper para saber se conta para a árvore
    public function isSuccessful(): bool
    {
        return $this === self::Paid;
    }
}