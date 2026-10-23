<?php

namespace App\Models;

use App\Models\Concerns\GeneratesAccessCode;
use Illuminate\Database\Eloquent\Builder;
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
        'paid_at',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'terms_accepted_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    /**
     * Só o que entrou. Uma encomenda pendente pode nunca vir a ser paga,
     * e não conta para nada que se mostre ou se some.
     */
    public function scopePaid(Builder $query): void
    {
        $query->where('status', self::STATUS_PAID);
    }

    /**
     * O nome tal como aparece na lista pública: primeiro e último.
     *
     * Os nomes do meio ficam de fora porque a lista é pública e o
     * nome completo só é preciso no recibo.
     */
    public function publicName(): string
    {
        if ($this->is_anonymous) {
            return 'Anónimo';
        }

        $parts = preg_split('/\s+/u', trim($this->buyer_name), -1, PREG_SPLIT_NO_EMPTY);

        if (count($parts) <= 1) {
            return $parts[0] ?? 'Anónimo';
        }

        return $parts[0] . ' ' . end($parts);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Uma encomenda pode ter várias tentativas de pagamento.
     * Idêntico ao que a Donation declara — é o que torna o bazar
     * utilizável pela máquina de pagamentos sem lhe tocar.
     */
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
