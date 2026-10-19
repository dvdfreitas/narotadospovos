<?php

namespace App\Models;

use App\Enums\DonationStatus;
use App\Models\Concerns\GeneratesAccessCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    ];

    /**
     * Um donativo pode ter várias tentativas de pagamento.
     */
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
