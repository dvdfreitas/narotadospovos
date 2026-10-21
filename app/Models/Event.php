<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Event extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'location',
        'image',
        'url',
        'visible',
    ];

    protected $casts = [
        'visible' => 'boolean',
    ];

    public function dates(): HasMany
    {
        return $this->hasMany(EventDate::class)->orderBy('date')->orderBy('start_time');
    }

    public function hasMoreInfo(): bool
    {
        return filled($this->url);
    }

    /**
     * Os dias que se realizam.
     */
    public function activeDates(): Collection
    {
        return $this->dates->reject(fn (EventDate $day) => $day->is_cancelled);
    }

    /**
     * O evento está cancelado quando nenhum dos seus dias se realiza.
     */
    public function isCancelled(): bool
    {
        return $this->dates->isNotEmpty() && $this->activeDates()->isEmpty();
    }

    /**
     * O dia a destacar: o primeiro que ainda não passou, ou o último quando
     * já passaram todos. Num evento cancelado servem os dias cancelados,
     * por serem os únicos que tem.
     */
    public function nextDate(): ?Carbon
    {
        $dates = $this->activeDates();

        if ($dates->isEmpty()) {
            $dates = $this->dates;
        }

        $next = $dates->first(fn (EventDate $day) => $day->date->gte(Carbon::today()));

        return ($next ?? $dates->last())?->date;
    }

    public function happensToday(): bool
    {
        return $this->activeDates()->contains(fn (EventDate $day) => $day->date->isToday());
    }

    /**
     * Os dias prontos para escrever: "5", "6", "8 de dezembro". O mês aparece
     * no último dia e sempre que o dia seguinte muda de mês. Três ou mais dias
     * seguidos, sem cancelamentos, juntam-se num intervalo.
     */
    public function dateLabels(): Collection
    {
        $dates = $this->dates->values();

        if ($dates->isEmpty()) {
            return collect();
        }

        $first = $dates->first();
        $last = $dates->last();

        if ($dates->count() === 1) {
            return collect([[
                'text' => ucfirst($first->date->locale('pt')->translatedFormat('l, j \d\e F')),
                'cancelled' => $first->is_cancelled,
            ]]);
        }

        $isRange = $dates->count() >= 3
            && (int) $first->date->diffInDays($last->date) === $dates->count() - 1
            && $dates->every(fn (EventDate $day) => ! $day->is_cancelled);

        if ($isRange) {
            $opening = $first->date->month === $last->date->month ? 'j' : 'j \d\e F';

            return collect([[
                'text' => $first->date->locale('pt')->translatedFormat($opening)
                    .' a '.$last->date->locale('pt')->translatedFormat('j \d\e F'),
                'cancelled' => false,
            ]]);
        }

        return $dates->map(function (EventDate $day, int $i) use ($dates) {
            $next = $dates->get($i + 1);
            $showsMonth = $next === null || $next->date->month !== $day->date->month;

            return [
                'text' => $day->date->locale('pt')->translatedFormat($showsMonth ? 'j \d\e F' : 'j'),
                'cancelled' => $day->is_cancelled,
            ];
        });
    }

    public function scopeVisible(Builder $query): void
    {
        $query->where('visible', true);
    }

    public function scopeUpcoming(Builder $query): void
    {
        $query->whereHas('dates', fn (Builder $dates) => $dates->where('date', '>=', today()->toDateString()))
            ->withMin('dates as first_date', 'date')
            ->orderBy('first_date');
    }

    public function scopePast(Builder $query): void
    {
        $query->whereDoesntHave('dates', fn (Builder $dates) => $dates->where('date', '>=', today()->toDateString()))
            ->withMax('dates as last_date', 'date')
            ->orderByDesc('last_date');
    }
}
