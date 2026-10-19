<?php

namespace App\Models;

use App\Models\Concerns\GeneratesAccessCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Order extends Model
{
    use GeneratesAccessCode;

    public const STATUS_PENDING   = 'pending';
    public const STATUS_PAID      = 'paid';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_EXPIRED   = 'expired';

    /**
     * O access_code fica de fora: é o trait que o gera.
     */
    protected $fillable = [
        'status',
        'total',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'tax_number',
        'is_anonymous',
        'address_line',
        'postal_code',
        'city',
        'terms_accepted_at',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'terms_accepted_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Uma encomenda pode ter várias tentativas de pagamento.
     * Idêntico ao que a Donation declara — é o que torna a loja
     * utilizável pela máquina de pagamentos sem lhe tocar.
     */
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
