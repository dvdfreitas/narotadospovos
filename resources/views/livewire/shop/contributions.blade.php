<?php

use App\Models\Order;
use function Livewire\Volt\{computed, on, state};

state(['page' => 1]);

/**
 * Páginas pequenas, porque a lista vive numa coluna lateral que acompanha
 * o scroll: tem de caber inteira no ecrã. Locked para o browser não pedir
 * a lista toda de uma vez.
 */
state(['perPage' => 6])->locked();

$count = computed(fn () => Order::paid()->count());

$pages = computed(fn () => max(1, (int) ceil($this->count / $this->perPage)));

/**
 * As encomendas pagas desta página, já reduzidas ao que pode ser público.
 *
 * Computed e não state: o state viaja até ao browser no snapshot do
 * Livewire, e com ele iria o email e o telemóvel de cada comprador, mesmo
 * sem aparecerem no HTML. Daqui só sai o que a lista mostra.
 */
$contributions = computed(fn () => Order::paid()
    ->with('items')
    ->latest('paid_at')
    ->latest('id')
    ->forPage($this->page, $this->perPage)
    ->get()
    ->map(function (Order $order) {
        $name = $order->publicName();

        return [
            'id'        => $order->id,
            'name'      => $name,
            'anonymous' => $order->is_anonymous,
            'initials'  => collect(explode(' ', $name))->map(fn ($part) => mb_substr($part, 0, 1))->join(''),
            'items'     => $order->items->map(fn ($item) => [
                'quantity' => $item->quantity,
                'label'    => "{$item->product_name} — {$item->variant_label}",
            ]),
            'total'     => number_format($order->total, 2, ',', ' ') . ' €',
            'when'      => $order->paid_at?->locale('pt')->diffForHumans(),
            'date'      => $order->paid_at?->toIso8601String(),
        ];
    }));

// O page vem do browser e pode ser mexido: fica sempre dentro dos limites.
$previous = function () {
    $this->page = max(1, $this->page - 1);
};

$next = function () {
    $this->page = min($this->pages, $this->page + 1);
};

// Disparado pela loja quando o pagamento de quem está na página entra.
// Volta à primeira página, que é onde a pessoa acabou de aparecer.
on(['contribution-paid' => function () {
    $this->page = 1;
    unset($this->contributions, $this->count, $this->pages);
}]);
?>

<div class="overflow-hidden rounded-xl border border-stone-200 bg-white">
    <div class="flex items-baseline justify-between gap-3 border-b border-stone-100 px-5 py-4">
        <h2 id="shop-contributions-title" class="m-0 text-base font-semibold tracking-tight text-slate-900">Quem já contribuiu</h2>
        @if ($this->count > 0)
            <span class="text-xs tabular-nums text-slate-500">{{ $this->count }} {{ $this->count === 1 ? 'contributo' : 'contributos' }}</span>
        @endif
    </div>

    @if ($this->count === 0)
        <div class="px-5 py-10 text-center">
            <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-sky-50 text-[#006c94]">
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M10 16.5s-6.5-3.8-6.5-8.3A3.5 3.5 0 0 1 10 6.3a3.5 3.5 0 0 1 6.5 1.9c0 4.5-6.5 8.3-6.5 8.3Z" stroke-linejoin="round" /></svg>
            </div>
            <p class="mb-0 mt-3 text-center text-sm font-normal text-slate-600">Ainda ninguém contribuiu.<br>Seja o primeiro.</p>
        </div>
    @else
        <ul role="list" wire:loading.class="opacity-60" wire:target="previous, next"
            class="m-0 divide-y divide-stone-100 p-0 transition-opacity motion-reduce:transition-none">
            @foreach ($this->contributions as $contribution)
                <li wire:key="contribution-{{ $contribution['id'] }}" class="flex gap-3 px-5 py-3.5">
                    <span aria-hidden="true" @class([
                        'mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-semibold',
                        'bg-sky-50 text-[#006c94]' => ! $contribution['anonymous'],
                        'bg-stone-100 text-stone-400' => $contribution['anonymous'],
                    ])>
                        @if ($contribution['anonymous'])
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10 16.5s-6.5-3.8-6.5-8.3A3.5 3.5 0 0 1 10 6.3a3.5 3.5 0 0 1 6.5 1.9c0 4.5-6.5 8.3-6.5 8.3Z" stroke-linejoin="round" /></svg>
                        @else
                            {{ $contribution['initials'] }}
                        @endif
                    </span>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-baseline justify-between gap-2">
                            <p @class([
                                'm-0 truncate text-left text-sm font-semibold',
                                'text-slate-900' => ! $contribution['anonymous'],
                                'italic text-slate-500' => $contribution['anonymous'],
                            ])>{{ $contribution['name'] }}</p>
                            <span class="shrink-0 text-sm font-semibold tabular-nums text-slate-900">{{ $contribution['total'] }}</span>
                        </div>
                        <ul role="list" class="m-0 mt-0.5 p-0 text-xs leading-relaxed text-slate-600">
                            @foreach ($contribution['items'] as $item)
                                <li><span class="tabular-nums">{{ $item['quantity'] }}×</span> {{ $item['label'] }}</li>
                            @endforeach
                        </ul>
                        @if ($contribution['when'])
                            <time datetime="{{ $contribution['date'] }}" class="mt-0.5 block text-[11px] text-slate-400">{{ $contribution['when'] }}</time>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>

        @if ($this->pages > 1)
            @php($first = ($page - 1) * $perPage + 1)
            @php($last = min($page * $perPage, $this->count))
            <nav aria-label="Páginas de contributos" class="flex items-center justify-between gap-3 border-t border-stone-100 px-3 py-2">
                <button type="button" wire:click="previous" @disabled($page <= 1)
                    aria-label="Contributos mais recentes"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full text-slate-600 hover:bg-stone-100 hover:text-[#006c94] focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#006c94] disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-slate-600">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12.5 4.5 7 10l5.5 5.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                </button>

                <span class="text-xs tabular-nums text-slate-500" aria-live="polite">{{ $first }}–{{ $last }} de {{ $this->count }}</span>

                <button type="button" wire:click="next" @disabled($page >= $this->pages)
                    aria-label="Contributos mais antigos"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-full text-slate-600 hover:bg-stone-100 hover:text-[#006c94] focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#006c94] disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:text-slate-600">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M7.5 4.5 13 10l-5.5 5.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                </button>
            </nav>
        @endif
    @endif
</div>
