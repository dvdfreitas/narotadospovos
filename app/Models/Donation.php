<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'donor_name',
        'donor_email',
        'is_anonymous',
        'public_message',
        'is_gift',
        'gift_recipient_name',
        'gift_recipient_email',
        'gift_message',
        'access_code',
    ];
}
