<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'starts_at',
        'ends_at',
        'location',
        'image',
        'url',
        'is_cancelled',
        'cancellation_reason',
        'visible',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_cancelled' => 'boolean',
        'visible' => 'boolean',
    ];

    public function hasMoreInfo(): bool
    {
        return filled($this->url);
    }

    public function scopeVisible(Builder $query): void
    {
        $query->where('visible', true);
    }

    public function scopeUpcoming(Builder $query): void
    {
        $query->where('starts_at', '>=', now())->orderBy('starts_at');
    }

    public function scopePast(Builder $query): void
    {
        $query->where('starts_at', '<', now())->orderByDesc('starts_at');
    }
}
