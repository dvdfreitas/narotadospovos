<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    // Garante que NÃO tens linhas como:
    // protected $primaryKey = 'outra_coisa';
    // public $incrementing = false;

    protected $fillable = [
        'amount',
        'donor_name',
        'donor_email',
        'donor_phone',      // Novo
        'nif',              // Novo
        'is_anonymous',
        'public_message',
        'is_gift',
        'gift_recipient_name',
        'gift_recipient_email',
        'gift_message',
        'payment_status',   // Novo
        'payment_gateway_id', // Novo
        'access_code',
    ];
}
