<?php

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

new #[Layout('layouts.app')] class extends Component {
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    /** '' mostra todas; senão um Order::STATUS_*. */
    #[Url(except: '')]
    public string $status = '';

    /** Só o id: o modelo inteiro iria no snapshot a cada pedido. */
    public ?int $selectedId = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    /**
     * A mesma pesquisa serve a tabela e o CSV, para que o ficheiro traga
     * exactamente o que está no ecrã.
     *
     * O where agrupado é obrigatório: sem ele, o orWhere escapava ao filtro
     * de estado e "Pagas" mostrava pendentes que casassem com a pesquisa.
     */
    private function query(): Builder
    {
        $search = trim($this->search);

        return Order::query()
            ->when($this->status !== '', fn (Builder $q) => $q->where('status', $this->status))
            ->when($search !== '', fn (Builder $q) => $q->where(fn (Builder $q) => $q
                ->where('buyer_name', 'like', "%{$search}%")
                ->orWhere('buyer_email', 'like', "%{$search}%")
                ->orWhere('buyer_phone', 'like', "%{$search}%")
                ->orWhere('tax_number', 'like', "%{$search}%")
                ->orWhere('access_code', $search)
                ->orWhereHas('payments', fn (Builder $q) => $q->where('reference', $search))
            ))
            ->latest();
    }

    public function with(): array
    {
        return [
            'stats' => [
                'total_paid'    => Order::paid()->sum('total'),
                'paid_count'    => Order::paid()->count(),
                'pending_count' => Order::where('status', Order::STATUS_PENDING)->count(),
            ],
            'orders' => $this->query()
                ->with(['items', 'payments' => fn ($q) => $q->latest('id')])
                ->paginate(20),
        ];
    }

    #[Computed]
    public function selected(): ?Order
    {
        return $this->selectedId
            ? Order::with(['items', 'payments' => fn ($q) => $q->latest('id')])->find($this->selectedId)
            : null;
    }

    public function show(int $id): void
    {
        $this->selectedId = $id;
    }

    public function close(): void
    {
        $this->selectedId = null;
    }

    /**
     * Para a contabilidade e para passar recibos.
     *
     * Ponto e vírgula e BOM em UTF-8: é o que o Excel em português abre
     * directamente, com os acentos certos e cada campo na sua coluna.
     */
    public function export(): StreamedResponse
    {
        $orders = $this->query()->with(['items', 'payments' => fn ($q) => $q->latest('id')])->get();

        return response()->streamDownload(function () use ($orders) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'Encomenda', 'Criada', 'Paga', 'Estado', 'Total', 'Nome', 'Email',
                'Telemóvel', 'NIF', 'Morada', 'Código postal', 'Localidade',
                'Anónimo', 'Artigos', 'Referência MB Way',
            ], ';');

            foreach ($orders as $order) {
                fputcsv($out, [
                    $order->id,
                    $order->created_at->format('Y-m-d H:i'),
                    $order->paid_at?->format('Y-m-d H:i'),
                    $order->status,
                    number_format($order->total, 2, ',', ''),
                    $order->buyer_name,
                    $order->buyer_email,
                    $order->buyer_phone,
                    $order->tax_number,
                    $order->address_line,
                    $order->postal_code,
                    $order->city,
                    $order->is_anonymous ? 'Sim' : 'Não',
                    $order->items->map(fn ($item) => "{$item->quantity}x {$item->product_name} ({$item->variant_label})")->join(', '),
                    $order->payments->first()?->reference,
                ], ';');
            }

            fclose($out);
        }, 'loja-solidaria-' . now()->format('Y-m-d') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
};
?>

@php
    $orderBadge = fn (string $status) => match ($status) {
        Order::STATUS_PAID      => ['Paga', 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'],
        Order::STATUS_PENDING   => ['Por pagar', 'bg-yellow-50 text-yellow-800 ring-yellow-600/20'],
        Order::STATUS_CANCELLED => ['Cancelada', 'bg-gray-50 text-gray-600 ring-gray-500/10'],
        Order::STATUS_EXPIRED   => ['Expirada', 'bg-gray-50 text-gray-600 ring-gray-500/10'],
        default                 => [$status, 'bg-gray-50 text-gray-600 ring-gray-500/10'],
    };

    $paymentLabel = fn (?string $status) => match ($status) {
        Payment::STATUS_PENDING   => 'Por enviar',
        Payment::STATUS_REQUESTED => 'À espera do cliente',
        Payment::STATUS_UNKNOWN   => 'Sem resposta da ifthenpay',
        Payment::STATUS_PAID      => 'Pago',
        Payment::STATUS_REJECTED  => 'Recusado',
        Payment::STATUS_EXPIRED   => 'Expirou',
        Payment::STATUS_FAILED    => 'Não criado',
        null                      => 'Sem tentativas',
        default                   => $status,
    };

    $money = fn ($value) => number_format($value, 2, ',', ' ') . ' €';
@endphp

<div class="min-h-screen bg-gray-50/50 pb-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- HEADER & STATS --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Pagamentos — Loja Solidária</h1>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <dt class="truncate text-sm font-medium text-gray-500">Total angariado</dt>
                    <dd class="mt-2 text-3xl font-bold tracking-tight text-emerald-600 tabular-nums">{{ $money($stats['total_paid']) }}</dd>
                </div>
                <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <dt class="truncate text-sm font-medium text-gray-500">Encomendas pagas</dt>
                    <dd class="mt-2 text-3xl font-bold tracking-tight text-gray-900 tabular-nums">{{ $stats['paid_count'] }}</dd>
                </div>
                <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <dt class="truncate text-sm font-medium text-gray-500">Por pagar</dt>
                    <dd class="mt-2 text-3xl font-bold tracking-tight text-yellow-600 tabular-nums">{{ $stats['pending_count'] }}</dd>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden">

            {{-- Toolbar --}}
            <div class="border-b border-gray-100 px-6 py-4 flex flex-col lg:flex-row justify-between lg:items-center gap-4">
                <div class="flex flex-wrap gap-2" role="group" aria-label="Filtrar por estado">
                    @foreach (['' => 'Todas', Order::STATUS_PAID => 'Pagas', Order::STATUS_PENDING => 'Por pagar'] as $value => $label)
                        <button type="button" wire:click="$set('status', '{{ $value }}')"
                            aria-pressed="{{ $status === $value ? 'true' : 'false' }}"
                            @class([
                                'rounded-md px-3 py-1.5 text-sm font-medium ring-1 ring-inset',
                                'bg-emerald-600 text-white ring-emerald-600' => $status === $value,
                                'bg-white text-gray-700 ring-gray-300 hover:bg-gray-50' => $status !== $value,
                            ])>{{ $label }}</button>
                    @endforeach
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative w-full sm:w-72">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="search"
                            aria-label="Pesquisar encomendas"
                            placeholder="Nome, email, telemóvel, NIF, referência…"
                            class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6"
                        >
                    </div>
                    <button type="button" wire:click="export"
                        class="inline-flex items-center justify-center gap-1.5 rounded-md bg-white px-3 py-1.5 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M10 3v10m0 0-4-4m4 4 4-4M4 15v2h12v-2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                        Exportar CSV
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comprador</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artigos</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3"><span class="sr-only">Detalhe</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($orders as $order)
                            @php([$badgeLabel, $badgeClass] = $orderBadge($order->status))
                            <tr wire:key="order-{{ $order->id }}" class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900">
                                        {{ $order->buyer_name }}
                                        @if ($order->is_anonymous)
                                            <span class="ml-1 rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-medium uppercase text-gray-600">anónimo</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $order->buyer_email }} · {{ $order->buyer_phone }}</div>
                                    <div class="text-[10px] text-gray-400">#{{ $order->id }} • {{ $order->created_at->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    @foreach ($order->items as $item)
                                        <div>{{ $item->quantity }}× {{ $item->product_name }} <span class="text-gray-400">— {{ $item->variant_label }}</span></div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-right font-semibold text-gray-900 tabular-nums whitespace-nowrap">{{ $money($order->total) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClass }}">{{ $badgeLabel }}</span>
                                    @if ($order->status !== Order::STATUS_PAID)
                                        <div class="mt-1 text-xs text-gray-500">{{ $paymentLabel($order->payments->first()?->status) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button" wire:click="show({{ $order->id }})" class="text-sm font-medium text-emerald-700 hover:text-emerald-900">
                                        Ver<span class="sr-only"> encomenda {{ $order->id }}</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">Nenhuma encomenda encontrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-100 px-6 py-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    {{-- DETALHE --}}
    @if ($order = $this->selected)
        @php([$badgeLabel, $badgeClass] = $orderBadge($order->status))
        <div class="fixed inset-0 z-40 flex justify-end" role="dialog" aria-modal="true" aria-labelledby="order-detail-title"
            x-data x-on:keydown.escape.window="$wire.close()">
            <div class="absolute inset-0 bg-gray-900/40" wire:click="close"></div>

            <div class="relative h-full w-full max-w-lg overflow-y-auto bg-white shadow-xl">
                <div class="flex items-start justify-between border-b border-gray-100 px-6 py-5">
                    <div>
                        <h2 id="order-detail-title" class="text-lg font-semibold text-gray-900">Encomenda #{{ $order->id }}</h2>
                        <span class="mt-1 inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClass }}">{{ $badgeLabel }}</span>
                    </div>
                    <button type="button" wire:click="close" aria-label="Fechar" class="rounded-md p-1 text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="m5 5 10 10M5 15 15 5" stroke-linecap="round" /></svg>
                    </button>
                </div>

                <div class="space-y-8 px-6 py-6">
                    <section>
                        <h3 class="text-sm font-semibold text-gray-900">Comprador</h3>
                        <dl class="mt-3 grid grid-cols-3 gap-x-4 gap-y-2 text-sm">
                            <dt class="text-gray-500">Nome</dt>
                            <dd class="col-span-2 font-medium text-gray-900">{{ $order->buyer_name }}</dd>
                            <dt class="text-gray-500">Na lista pública</dt>
                            <dd class="col-span-2 text-gray-900">{{ $order->publicName() }}</dd>
                            <dt class="text-gray-500">Email</dt>
                            <dd class="col-span-2 text-gray-900 break-all"><a href="mailto:{{ $order->buyer_email }}" class="hover:underline">{{ $order->buyer_email }}</a></dd>
                            <dt class="text-gray-500">Telemóvel</dt>
                            <dd class="col-span-2 text-gray-900">{{ $order->buyer_phone }}</dd>
                            <dt class="text-gray-500">NIF</dt>
                            <dd class="col-span-2 text-gray-900">{{ $order->tax_number ?? '—' }}</dd>
                            <dt class="text-gray-500">Morada</dt>
                            <dd class="col-span-2 text-gray-900">
                                @if ($order->address_line || $order->postal_code || $order->city)
                                    {{ $order->address_line }}<br>{{ $order->postal_code }} {{ $order->city }}
                                @else
                                    —
                                @endif
                            </dd>
                            <dt class="text-gray-500">Termos aceites</dt>
                            <dd class="col-span-2 text-gray-900">{{ $order->terms_accepted_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                        </dl>
                    </section>

                    <section>
                        <h3 class="text-sm font-semibold text-gray-900">Artigos</h3>
                        <ul role="list" class="mt-3 divide-y divide-gray-100 rounded-lg ring-1 ring-gray-100">
                            @foreach ($order->items as $item)
                                <li class="flex justify-between gap-4 px-4 py-3 text-sm">
                                    <span>{{ $item->quantity }}× {{ $item->product_name }} <span class="text-gray-400">— {{ $item->variant_label }}</span></span>
                                    <span class="tabular-nums text-gray-700 whitespace-nowrap">{{ $money(bcmul($item->unit_price, (string) $item->quantity, 2)) }}</span>
                                </li>
                            @endforeach
                            <li class="flex justify-between gap-4 px-4 py-3 text-sm font-semibold">
                                <span>Total</span>
                                <span class="tabular-nums">{{ $money($order->total) }}</span>
                            </li>
                        </ul>
                    </section>

                    <section>
                        <h3 class="text-sm font-semibold text-gray-900">Tentativas de pagamento</h3>
                        @forelse ($order->payments as $payment)
                            <div wire:key="payment-{{ $payment->id }}" class="mt-3 rounded-lg p-4 text-sm ring-1 ring-gray-100">
                                <div class="flex justify-between gap-4">
                                    <span class="font-mono text-gray-900">{{ $payment->reference ?? '—' }}</span>
                                    <span @class([
                                        'font-medium',
                                        'text-emerald-700' => $payment->status === Payment::STATUS_PAID,
                                        'text-gray-600' => $payment->status !== Payment::STATUS_PAID,
                                    ])>{{ $paymentLabel($payment->status) }}</span>
                                </div>
                                <div class="mt-1 text-xs text-gray-500">
                                    Pedido a {{ $payment->created_at->format('d/m/Y H:i') }}
                                    @if ($payment->confirmed_at)
                                        · confirmado a {{ $payment->confirmed_at->format('d/m/Y H:i') }}
                                    @endif
                                </div>
                                @if ($payment->provider_status || $payment->provider_message)
                                    <div class="mt-1 text-xs text-gray-400">ifthenpay: {{ $payment->provider_status }} {{ $payment->provider_message }}</div>
                                @endif
                            </div>
                        @empty
                            <p class="mt-3 text-sm text-gray-500">Nenhuma tentativa registada.</p>
                        @endforelse
                    </section>
                </div>
            </div>
        </div>
    @endif
</div>
