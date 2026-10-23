<?php

use App\Models\Order;
use App\Models\Partner;
use App\Models\Story;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

/**
 * A primeira página depois do login: o estado do site e atalhos para
 * cada área. Os números do bazar só aparecem a administradores — são os
 * mesmos de /admin/pagamentos.
 */
new #[Layout('layouts.app')] class extends Component {
    public function with(): array
    {
        $isAdmin = Gate::allows('admin');

        return [
            'firstName' => strtok(auth()->user()->name, ' '),
            'isAdmin'   => $isAdmin,
            'shop'      => $isAdmin ? [
                'total'   => Order::paid()->sum('total'),
                'paid'    => Order::paid()->count(),
                'pending' => Order::where('status', Order::STATUS_PENDING)->count(),
                'recent'  => Order::paid()->with('items')->latest('paid_at')->take(5)->get(),
            ] : null,
            'storiesCount'  => Story::published()->count(),
            'latestStory'   => Story::published()->first(),
            'partnersCount' => Partner::where('visible', true)->count(),
        ];
    }
};
?>

@php($money = fn ($value) => number_format($value, 2, ',', ' ') . ' €')

<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        <header class="border-b border-gray-200 pb-6">
            <p class="text-sm text-gray-500">{{ ucfirst(now()->locale('pt')->translatedFormat('l, j \d\e F')) }}</p>
            <h1 class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">Olá, {{ $firstName }}</h1>
            <p class="mt-2 text-gray-600">Daqui gere o conteúdo do site da Na Rota dos Povos.</p>
        </header>

        {{-- BAZAR SOLIDÁRIO --}}
        @if ($isAdmin)
            <section aria-labelledby="dashboard-shop" class="mt-10">
                <div class="flex flex-wrap items-baseline justify-between gap-3">
                    <h2 id="dashboard-shop" class="text-lg font-semibold text-gray-900">Bazar Solidário</h2>
                    <a href="{{ route('admin.orders') }}" class="group inline-flex items-center gap-1 text-sm font-semibold text-nrp-blue hover:text-gray-900">
                        Ver todos os pagamentos
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5 motion-reduce:transition-none" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 10h12m-5-5 5 5-5 5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    </a>
                </div>

                <div class="mt-4 grid gap-6 lg:grid-cols-3">
                    <dl class="grid grid-cols-3 gap-4 lg:col-span-3 xl:col-span-1 xl:grid-cols-1">
                        <div class="rounded-xl p-5 ring-1 ring-gray-200">
                            <dt class="text-sm text-gray-500">Total angariado</dt>
                            <dd class="mt-1 text-2xl font-semibold tabular-nums text-emerald-600 sm:text-3xl">{{ $money($shop['total']) }}</dd>
                        </div>
                        <div class="rounded-xl p-5 ring-1 ring-gray-200">
                            <dt class="text-sm text-gray-500">Contributos pagos</dt>
                            <dd class="mt-1 text-2xl font-semibold tabular-nums text-gray-900 sm:text-3xl">{{ $shop['paid'] }}</dd>
                        </div>
                        <div class="rounded-xl p-5 ring-1 ring-gray-200">
                            <dt class="text-sm text-gray-500">Por pagar</dt>
                            <dd class="mt-1 text-2xl font-semibold tabular-nums text-amber-600 sm:text-3xl">{{ $shop['pending'] }}</dd>
                        </div>
                    </dl>

                    <div class="overflow-hidden rounded-xl ring-1 ring-gray-200 lg:col-span-3 xl:col-span-2">
                        <h3 class="border-b border-gray-100 px-5 py-3 text-sm font-semibold text-gray-900">Últimos contributos</h3>
                        @forelse ($shop['recent'] as $order)
                            <a href="{{ route('admin.orders', ['q' => $order->buyer_email]) }}"
                                class="flex items-center justify-between gap-4 border-b border-gray-100 px-5 py-3 last:border-b-0 hover:bg-gray-50">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="truncate font-medium text-gray-900">{{ $order->buyer_name }}</span>
                                        @if ($order->is_anonymous)
                                            <span class="shrink-0 rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-medium uppercase text-gray-600">anónimo</span>
                                        @endif
                                    </div>
                                    <div class="truncate text-xs text-gray-500">
                                        {{ $order->items->map(fn ($item) => "{$item->quantity}× {$item->product_name}")->join(', ') }}
                                    </div>
                                </div>
                                <div class="shrink-0 text-right">
                                    <div class="font-semibold tabular-nums text-gray-900">{{ $money($order->total) }}</div>
                                    <div class="text-xs text-gray-400">{{ $order->paid_at?->locale('pt')->diffForHumans() }}</div>
                                </div>
                            </a>
                        @empty
                            <p class="px-5 py-8 text-center text-sm text-gray-500">Ainda não há contributos pagos.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        @endif

        {{-- CONTEÚDO DO SITE --}}
        <section aria-labelledby="dashboard-content" class="mt-12">
            <h2 id="dashboard-content" class="text-lg font-semibold text-gray-900">Conteúdo do site</h2>

            <div class="mt-4 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
                {{-- Notícias --}}
                <div class="flex flex-col rounded-xl p-6 ring-1 ring-gray-200">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-sky-50 text-nrp-blue">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" /></svg>
                        </span>
                        <div>
                            <h3 class="font-semibold text-gray-900">Notícias</h3>
                            <p class="text-sm text-gray-500">{{ $storiesCount }} {{ $storiesCount === 1 ? 'publicada' : 'publicadas' }}</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-gray-600">
                        @if ($latestStory)
                            A mais recente é <span class="font-medium text-gray-900">{{ $latestStory->title }}</span>, de {{ $latestStory->displayDate() }}.
                        @else
                            Ainda não há notícias publicadas.
                        @endif
                    </p>
                    <div class="mt-auto flex flex-wrap gap-2 pt-5">
                        <a href="{{ route('stories.create') }}" class="inline-flex items-center rounded-lg bg-nrp-blue px-3 py-2 text-sm font-semibold text-white hover:bg-[#006c94]">Escrever notícia</a>
                        <a href="{{ route('stories.index') }}" class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Ver página</a>
                    </div>
                </div>

                {{-- Parceiros --}}
                <div class="flex flex-col rounded-xl p-6 ring-1 ring-gray-200">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-lime-50 text-lime-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                        </span>
                        <div>
                            <h3 class="font-semibold text-gray-900">Parceiros</h3>
                            <p class="text-sm text-gray-500">{{ $partnersCount }} {{ $partnersCount === 1 ? 'visível' : 'visíveis' }}</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-gray-600">
                        Aparecem em grelha na página inicial, com o logótipo de cada entidade que nos apoia.
                    </p>
                    <div class="mt-auto flex flex-wrap gap-2 pt-5">
                        @if ($isAdmin)
                            <a href="{{ route('admin.partners') }}" class="inline-flex items-center rounded-lg bg-nrp-blue px-3 py-2 text-sm font-semibold text-white hover:bg-[#006c94]">Gerir</a>
                            <a href="{{ route('admin.partners', ['novo' => 1]) }}" class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Acrescentar</a>
                        @endif
                        <a href="{{ route('partners.index') }}" class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Ver página</a>
                    </div>
                </div>

                {{-- Bazar --}}
                <div class="flex flex-col rounded-xl p-6 ring-1 ring-gray-200">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                        </span>
                        <div>
                            <h3 class="font-semibold text-gray-900">Bazar Solidário</h3>
                            <p class="text-sm text-gray-500">Acessível só por link</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-gray-600">
                        Cada compra transforma-se em bens para quem precisa. Pagamento por MB Way.
                    </p>
                    <div class="mt-auto flex flex-wrap gap-2 pt-5">
                        @if ($isAdmin)
                            <a href="{{ route('admin.orders') }}" class="inline-flex items-center rounded-lg bg-nrp-blue px-3 py-2 text-sm font-semibold text-white hover:bg-[#006c94]">Pagamentos</a>
                        @endif
                        <a href="{{ route('shop.index') }}" class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Ver bazar</a>
                    </div>
                </div>

                {{-- Campanha --}}
                <div class="flex flex-col rounded-xl p-6 ring-1 ring-gray-200">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-rose-50 text-rose-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                        </span>
                        <div>
                            <h3 class="font-semibold text-gray-900">Campanha</h3>
                            <p class="text-sm text-gray-500">Necessidades em curso</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-gray-600">
                        O que já foi angariado e o que ainda falta para cada necessidade.
                    </p>
                    <div class="mt-auto flex flex-wrap gap-2 pt-5">
                        <a href="{{ route('needs.index') }}" class="inline-flex items-center rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Ver página</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
