<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /**
     * product_name, variant_label e unit_price são cópias congeladas
     * no momento da compra. Não voltam a mudar.
     */
    protected $fillable = [
        'product_variant_id',
        'product_name',
        'variant_label',
        'unit_price',
        'quantity',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * O método chama-se variant() mas a coluna é product_variant_id,
     * por isso é preciso dizê-lo explicitamente.
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * unit_price × quantity, em aritmética exacta.
     * Nunca usar * aqui: converteria para vírgula flutuante.
     */
    public function lineTotal(): string
    {
        return bcmul($this->unit_price, (string) $this->quantity, 2);
    }
}
