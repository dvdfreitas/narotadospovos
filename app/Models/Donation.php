<?php

namespace App\Models;

use App\Enums\DonationStatus;
use App\Models\Concerns\GeneratesAccessCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Donation extends Model
{
    use HasFactory;
    use SoftDeletes;
    use GeneratesAccessCode;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'status' => DonationStatus::class,

        'is_anonymous' => 'boolean',
        'campaign_data' => 'array',
        'terms_accepted_at' => 'datetime',

        // Só mantém isto se adicionares a coluna na tabela:
        'confirmed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $donation) {
            // NÃO gerar access_code aqui — isso fica no trait.

            if (blank($donation->status)) {
                $donation->status = DonationStatus::Pending;
            }
        });
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', DonationStatus::Pending);
    }

    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', DonationStatus::Confirmed);
    }

    public function markAsConfirmed(?Carbon $when = null): void
    {
        $this->status = DonationStatus::Confirmed;
        $this->confirmed_at = $when ?? now();
        $this->save();
    }

    public function isPending(): bool
    {
        return $this->status === DonationStatus::Pending;
    }

    public function isConfirmed(): bool
    {
        return $this->status === DonationStatus::Confirmed;
    }

    public function statusLabelPt(): string
    {
        return $this->status->labelPt();
    }
}
