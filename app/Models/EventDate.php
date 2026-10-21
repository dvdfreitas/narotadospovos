<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventDate extends Model
{
    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'is_cancelled',
    ];

    protected $casts = [
        'date' => 'date',
        'is_cancelled' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
