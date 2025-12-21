<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'amount',
        'status',
        'provider_request_id',
        'provider_status',
        'provider_message',
    ];

    /**
     * Estado internos possíveis
     */
    public const STATUS_PENDING  = 'pending';
    public const STATUS_PAID     = 'paid';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_ERROR    = 'error';

    /**
     * Método de pagamento
     */
    public const METHOD_MBWAY = 'mbway';

    /**
     * Helpers de estado
     */
    public function markAsPending(): void
    {
        $this->update(['status' => self::STATUS_PENDING]);
    }

    public function markAsPaid(): void
    {
        $this->update(['status' => self::STATUS_PAID]);
    }

    public function markAsRejected(): void
    {
        $this->update(['status' => self::STATUS_REJECTED]);
    }

    public function markAsError(): void
    {
        $this->update(['status' => self::STATUS_ERROR]);
    }
}
