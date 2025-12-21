<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Não te esqueças disto para o Seeder funcionar
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'campaign_slug',
        'access_code',
        'amount',
        'currency',
        'status',          // Confirmado: 'status' e não 'payment_status'
        'donor_name',
        'donor_email',
        'donor_phone',
        'nif',
        'is_anonymous',
        'campaign_data',   // O campo JSON
        'terms_accepted_at',
    ];


    protected $casts = [
        'campaign_data' => 'array',         'is_anonymous' => 'boolean',
        'terms_accepted_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    // ... Relações (payments) ...
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
