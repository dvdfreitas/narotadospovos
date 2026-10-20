<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Payment;
use App\Services\Payments\CheckMbWayPayment;
use App\Services\Payments\StartMbWayPayment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use function Livewire\Volt\{layout, computed, rules, state};

layout('layouts.guest');

state([
    'step' => 1,
    'lines' => [],

    // Só o id: o estado viaja até ao browser e volta a cada interacção,
    // e o modelo inteiro levaria lá todas as colunas do pagamento.
    'paymentId' => null,

    'buyer_name'   => '',
    'buyer_email'  => '',
    'buyer_phone'  => '',
    'tax_number'   => '',
    'address_line' => '',
    'postal_code'  => '',
    'city'         => '',
    'is_anonymous' => false,
    'terms'        => false,
]);

/**
 * O telemóvel é o único campo que o pagamento exige: 91, 92, 93 ou 96,
 * nove dígitos. O MB Way só funciona com números portugueses associados
 * a uma conta bancária portuguesa.
 *
 * O NIF valida o comprimento mas não o dígito de controlo — 123456789
 * passa aqui e é inválido. Ver documentation/backlog.md
 */
rules([
    'buyer_name'   => 'required|string|max:255',
    'buyer_email'  => 'required|email|max:255',
    'buyer_phone'  => ['required', 'regex:/^9[1236][0-9]{7}$/'],
    'tax_number'   => 'nullable|digits:9',
    'address_line' => 'nullable|string|max:255',
    'postal_code'  => ['nullable', 'regex:/^\d{4}-\d{3}$/'],
    'city'         => 'nullable|string|max:255',
    'terms'        => 'accepted',
])->messages([
    'buyer_name.required'  => 'Diga-nos o seu nome.',
    'buyer_email.required' => 'Precisamos do email para lhe enviar a confirmação.',
    'buyer_email.email'    => 'Este email não parece estar bem escrito.',
    'buyer_phone.required' => 'O telemóvel é preciso para o pagamento por MB Way.',
    'buyer_phone.regex'    => 'Indique um telemóvel português (+351) de nove dígitos, começado por 91, 92, 93 ou 96.',
    'tax_number.digits'    => 'O NIF tem nove dígitos.',
    'postal_code.regex'    => 'O código postal escreve-se como 4700-123.',
    'terms.accepted'       => 'É preciso aceitar a política de privacidade para continuar.',
]);

/**
 * Produtos vendáveis = os que têm pelo menos uma variante activa.
 * Não existe coluna "is_sellable": a resposta vem dos dados.
 */
$products = computed(function () {
    return Product::query()
        ->whereHas('variants', fn ($q) => $q->where('is_active', true))
        ->with(['variants' => fn ($q) => $q->where('is_active', true)->orderBy('quantity')->orderBy('price')])
        ->orderBy('name')
        ->get();
});

/**
 * Recebe a seleção do browser e repreça-a a partir da base de dados.
 *
 * Do browser só se aceita o que não se pode falsificar com proveito: que
 * variante e quantas. O preço está no localStorage e abre-se com a consola —
 * o que conta é o da base de dados.
 *
 * Uma variante inventada ou desactivada não aparece no resultado da consulta:
 * não é preciso rejeitá-la, ela não existe para esta pergunta.
 */
$startCheckout = function (array $selection) {
    $requested = collect($selection)
        ->mapWithKeys(fn ($line) => [
            (int) $line['variantId'] => max(1, min(99, (int) $line['quantity'])),
        ]);

    $this->lines = ProductVariant::with('product')
        ->whereIn('id', $requested->keys())
        ->where('is_active', true)
        ->get()
        ->map(fn ($variant) => [
            'variant_id'    => $variant->id,
            'product_name'  => $variant->product->name,
            'variant_label' => $variant->label,
            'unit_price'    => $variant->price,
            'quantity'      => $requested[$variant->id],
        ])
        ->values()
        ->all();

    // Seleção velha guardada no browser, com produtos que já saíram da loja.
    // O modal abre sem linhas e sem total, em vez de rebentar.
};

/**
 * O total das linhas já repreçadas pelo servidor.
 *
 * Uma conta, um sítio: este valor vai para orders.total, para
 * payments.amount e para a assinatura da notificação, e os três têm de ser
 * exactamente o mesmo texto. "25.00" e "25" dariam assinaturas diferentes.
 *
 * bcmul e bcadd mantêm tudo em texto exacto. O 2 final fixa as casas
 * decimais: sem ele, bcmul('25.00', '2') devolveria '50'.
 */
$total = computed(fn () => collect($this->lines)->reduce(
    fn ($sum, $line) => bcadd($sum, bcmul($line['unit_price'], (string) $line['quantity'], 2), 2),
    '0.00',
));

/**
 * O StartMbWayPayment é resolvido pelo tipo, e ele próprio recebe o
 * MbWayClient já com a chave — ver AppServiceProvider::register().
 */
$placeOrder = function (StartMbWayPayment $payments) {
    // Um código postal escrito à mão chega com espaços à volta do hífen
    // ou sem hífen nenhum. Guarda-se sempre na forma 0000-000.
    $this->postal_code = preg_replace(
        '/^(\d{4})\D*(\d{3})$/',
        '$1-$2',
        trim((string) $this->postal_code),
    );

    $this->validate();

    // O Livewire assina o estado, por isso $this->lines não pode ser alterado
    // no browser. Mas qualquer método público pode ser chamado directamente —
    // incluindo este, num componente onde o startCheckout nunca correu. Aí
    // lines está legitimamente vazio, e não queremos criar uma encomenda de
    // zero euros.
    if ($this->lines === []) {
        return;
    }

    $total = $this->total;

    // A encomenda e as linhas juntas: se uma linha falhasse a meio, ficaria
    // uma encomenda com um total que não bate certo com o que tem dentro.
    //
    // Os campos opcionais vazios guardam-se como null, não como '': um campo
    // de formulário por preencher chega como string vazia, e isso diria que
    // o NIF é a string vazia em vez de dizer que não há NIF.
    $order = DB::transaction(function () use ($total) {
        $order = Order::create([
            'total'             => $total,
            'status'            => Order::STATUS_PENDING,
            'buyer_name'        => $this->buyer_name,
            'buyer_email'       => $this->buyer_email,
            'buyer_phone'       => $this->buyer_phone,
            'tax_number'        => $this->tax_number ?: null,
            'address_line'      => $this->address_line ?: null,
            'postal_code'       => $this->postal_code ?: null,
            'city'              => $this->city ?: null,
            'is_anonymous'      => $this->is_anonymous,
            'terms_accepted_at' => now(),
        ]);

        foreach ($this->lines as $line) {
            $order->items()->create([
                'product_variant_id' => $line['variant_id'],
                'product_name'       => $line['product_name'],
                'variant_label'      => $line['variant_label'],
                'unit_price'         => $line['unit_price'],
                'quantity'           => $line['quantity'],
            ]);
        }

        return $order;
    });

    // Sem acentos e dentro dos 100 caracteres. É o que aparece na coluna
    // Descrição do backoffice da ifthenpay.
    $payment = $payments->start(
        $order,
        $total,
        $this->buyer_phone,
        'Loja Solidaria ' . $order->access_code,
    );

    $this->paymentId = $payment->id;

    // Só espera quem tem por quem esperar. Em failed a ifthenpay recusou
    // criar o pedido, e em unknown não sabemos se chegou — em nenhum dos
    // dois o telemóvel vai tocar, e o checkPayment não os resolveria.
    $this->step = $payment->status === Payment::STATUS_REQUESTED ? 2 : 3;
};

/** O pagamento em curso, para o ecrã de espera e o de resultado. */
$payment = computed(fn () => $this->paymentId ? Payment::find($this->paymentId) : null);

/**
 * Volta ao formulário para uma nova tentativa.
 *
 * Só se oferece quando o pedido expirou — aí sabemos com certeza que não foi
 * pago. Nunca em unknown: a ifthenpay aceita a mesma referência duas vezes e
 * cria duas transações, por isso reenviar não retoma, duplica.
 */
$retry = function () {
    $this->paymentId = null;
    $this->step = 1;
};

/**
 * Chamado pelo wire:poll do ecrã de espera, de 5 em 5 segundos.
 *
 * O caminho normal é a notificação da ifthenpay actualizar a base de dados
 * sozinha, e aqui bastaria ler. A consulta existe para quando ela não chega —
 * e em desenvolvimento, onde não há URL público, é a única forma de o ecrã
 * avançar.
 *
 * Cache::add escreve só se a chave não existir: garante no máximo uma consulta
 * à API a cada 10 segundos por pagamento, mesmo com vários separadores
 * abertos. O endpoint de estado deles tem limite de taxa.
 * Ver documentation/backlog.md, "Para rever com calma".
 */
$checkPayment = function () {
    $payment = Payment::find($this->paymentId);

    if ($payment === null) {
        return;
    }

    if (! $payment->isFinal() && Cache::add("mbway-check-{$payment->id}", true, 10)) {
        app(CheckMbWayPayment::class)->check($payment);
        $payment->refresh();
    }

    if ($payment->isFinal()) {
        $this->step = 3;
    }
};
?>

<section
    x-data="{
        clearMessage: '',
        selections: {},
        cartOverflow: '',
        get cartLines() {
            return Object.values(this.selections).flat();
        },
        get cartUnits() {
            return this.cartLines.reduce((sum, line) => sum + line.quantity, 0);
        },
        money(cents) {
            return (cents / 100n).toLocaleString('pt-PT') + ',' + (cents % 100n).toString().padStart(2, '0') + ' €';
        },
        lineCents(line) {
            const [whole, fraction = ''] = line.unitPrice.split('.');
            return BigInt(whole + fraction.padEnd(2, '0')) * BigInt(line.quantity);
        },
        get cartTotal() {
            return this.money(this.cartLines.reduce((sum, line) => sum + this.lineCents(line), 0n));
        },
        openCart() {
            if (this.cartUnits === 0) return;

            // Repreça no servidor ANTES de mostrar seja o que for. Assim o
            // modal mostra um único total, o da base de dados — e não há dois
            // números para comparar.
            this.$wire.startCheckout(this.cartLines.map(line => ({
                variantId: Number(line.id.split(':')[1]),
                quantity: line.quantity,
            })));

            this.cartOverflow = document.body.style.overflow;
            this.$refs.cart.showModal();
            document.body.style.overflow = 'hidden';
        },
        clearSelection() {
            try {
                Object.keys(localStorage)
                    .filter(key => key.startsWith('nrp:shop:quantities:v1:'))
                    .forEach(key => localStorage.removeItem(key));
            } catch {
                // Reset the visible selection even when browser storage is unavailable.
            }
            this.$dispatch('nrp-shop-clear');
            this.clearMessage = 'Seleção limpa.';
        }
    }"
    x-on:nrp-shop-selection="selections[$event.detail.productId] = $event.detail.lines"
    class="bg-[#faf9f6]"
>
    @push('meta')
        <meta name="robots" content="noindex, nofollow">
    @endpush

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:py-14">
        <header class="mb-8 flex flex-wrap items-end justify-between gap-4 border-b border-stone-200 pb-7 sm:mb-10">
            <div>
                <h1 class="m-0 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Loja Solidária</h1>
                <p class="mb-0 mt-3 max-w-xl text-left text-base font-normal leading-relaxed text-slate-600">
                    Escolha como quer ajudar. Cada compra transforma-se em bens para quem precisa.
                </p>
            </div>
        </header>

        @if ($this->products->isNotEmpty())
            <span role="status" class="sr-only" x-text="clearMessage"></span>
            <x-shop.purchase-bar class="mb-6" />
        @endif

        <div class="grid auto-rows-fr gap-6 sm:grid-cols-2">
            @forelse ($this->products as $product)
                @php
                    $variantOptions = $product->variants->map(fn ($variant) => [
                        'id' => (string) $variant->id,
                        'label' => $variant->label,
                        'price' => number_format($variant->price, 2, ',', ' ').' €',
                        'unitPrice' => $variant->price,
                        'description' => $variant->description,
                    ])->values();
                @endphp

                <article
                    wire:key="product-{{ $product->id }}"
                    x-on:nrp-shop-clear.window="quantities = Object.fromEntries(variants.map(variant => [variant.id, 0]))"
                    x-data="{
                        variants: @js($variantOptions),
                        quantities: @js($variantOptions->mapWithKeys(fn ($variant) => [$variant['id'] => 0])),
                        minimum: 0,
                        productName: @js($product->name),
                        productId: @js((string) $product->id),
                        storageKey: @js('nrp:shop:quantities:v1:'.$product->id),
                        previousOverflow: '',
                        init() {
                            try {
                                const saved = JSON.parse(localStorage.getItem(this.storageKey));
                                if (saved && typeof saved === 'object' && !Array.isArray(saved)) {
                                    for (const variant of this.variants) {
                                        const quantity = saved[variant.id];
                                        if (Number.isInteger(quantity)) {
                                            this.quantities[variant.id] = Math.max(this.minimum, Math.min(99, quantity));
                                        }
                                    }
                                }
                            } catch {
                                // Keep the default selection if browser storage is unavailable or invalid.
                            }
                            this.$watch('quantities', () => {
                                this.publishSelection();
                                try {
                                    if (this.unitCount === 0) {
                                        localStorage.removeItem(this.storageKey);
                                    } else {
                                        localStorage.setItem(this.storageKey, JSON.stringify(this.quantities));
                                    }
                                } catch {
                                    // Quantity selection still works when the browser blocks storage.
                                }
                            });
                            this.publishSelection();
                        },
                        publishSelection() {
                            this.$dispatch('nrp-shop-selection', {
                                productId: this.productId,
                                lines: this.variants.filter(variant => this.quantities[variant.id] > 0).map(variant => ({
                                    id: this.productId + ':' + variant.id,
                                    product: this.productName,
                                    label: variant.label,
                                    unitPrice: variant.unitPrice,
                                    quantity: this.quantities[variant.id]
                                }))
                            });
                        },
                        get unitCount() {
                            return Object.values(this.quantities).reduce((sum, quantity) => sum + quantity, 0);
                        },
                        get totalPrice() {
                            const total = this.variants.reduce((sum, variant) => {
                                const [whole, fraction = ''] = variant.unitPrice.split('.');
                                return sum + BigInt(whole + fraction.padEnd(2, '0')) * BigInt(this.quantities[variant.id]);
                            }, 0n);
                            return (total / 100n).toLocaleString('pt-PT') + ',' + (total % 100n).toString().padStart(2, '0') + ' €';
                        },
                        updateQuantity(id, value) {
                            const amount = Number(value);
                            this.quantities[id] = Number.isFinite(amount) ? Math.max(this.minimum, Math.min(99, Math.trunc(amount))) : this.minimum;
                        },
                        openDetails() {
                            this.previousOverflow = document.body.style.overflow;
                            this.$refs.details.showModal();
                            document.body.style.overflow = 'hidden';
                        }
                    }"
                    class="flex h-full flex-col overflow-hidden rounded-xl border border-stone-200 bg-white transition-shadow hover:shadow-lg hover:shadow-stone-200/40 motion-reduce:transition-none lg:flex-row"
                >
                    <div class="relative aspect-square shrink-0 overflow-hidden bg-[#f5f1ea] lg:aspect-auto lg:w-44 xl:w-52">
                        @if ($product->image)
                            <picture>
                                @if ($product->image === 'images/products/cabaz-solidario.webp')
                                    <source media="(min-width: 1024px)" srcset="{{ asset('images/products/cabaz-card.webp') }}" width="768" height="1152">
                                @endif
                                <img
                                    src="{{ asset($product->image) }}"
                                    alt="Ilustração de {{ $product->name }}"
                                    width="768"
                                    height="768"
                                    loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                    decoding="async"
                                    class="absolute inset-0 h-full w-full object-cover object-center"
                                >
                            </picture>
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-sm text-stone-500">Imagem em breve</div>
                        @endif
                    </div>

                    <div class="flex min-h-[268px] min-w-0 flex-1 flex-col p-5 lg:p-6">
                        <h2 class="m-0 text-xl font-semibold tracking-tight text-slate-900">{{ $product->name }}</h2>
                        <button
                            type="button"
                            x-on:click="openDetails()"
                            aria-haspopup="dialog"
                            aria-controls="product-details-{{ $product->id }}"
                            class="mt-1 inline-flex min-h-11 items-center gap-1.5 self-start rounded text-sm text-slate-500 underline decoration-stone-300 underline-offset-4 hover:text-[#006c94] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#006c94]"
                        >
                            Ver descrição<span class="sr-only"> de {{ $product->name }}</span>
                            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M6 14 14 6M6 6h8v8" stroke-linecap="round" stroke-linejoin="round" /></svg>
                        </button>

                        <div class="mt-3 space-y-3">
                            @foreach ($product->variants as $variant)
                                <div class="flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <span class="block text-sm font-medium text-slate-800">{{ $variant->label }}</span>
                                        <span class="mt-0.5 block text-xs tabular-nums text-slate-500">{{ number_format($variant->price, 2, ',', ' ') }} € / un.</span>
                                    </div>
                                    <x-shop.quantity-selector
                                        :id="'quantity-'.$product->id.'-'.$variant->id"
                                        :product-name="$product->name.' — '.$variant->label"
                                        :variant-id="$variant->id"
                                        :show-label="false"
                                    />
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-auto flex items-center justify-between gap-3 pt-5">
                            <div>
                                <span class="mb-1 block text-xs text-slate-500">Subtotal</span>
                                <span aria-live="polite" aria-atomic="true" x-text="totalPrice" class="whitespace-nowrap text-2xl font-semibold tracking-tight tabular-nums text-slate-900">0,00 €</span>
                            </div>
                        </div>
                    </div>

                    <dialog
                        x-ref="details"
                        id="product-details-{{ $product->id }}"
                        aria-labelledby="product-details-title-{{ $product->id }}"
                        x-on:click.self="$el.close()"
                        x-on:close="document.body.style.overflow = previousOverflow"
                        class="m-auto max-h-[85dvh] w-[calc(100%-2rem)] max-w-lg overflow-y-auto rounded-2xl border-0 bg-white p-0 text-slate-900 shadow-2xl backdrop:bg-slate-950/50 backdrop:backdrop-blur-sm"
                    >
                        <div class="p-6 sm:p-8">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <span class="text-xs font-semibold uppercase tracking-widest text-[#006c94]">Sobre este produto</span>
                                    <h2 id="product-details-title-{{ $product->id }}" class="mb-0 mt-2 text-2xl font-semibold tracking-tight">{{ $product->name }}</h2>
                                </div>
                                <button type="button" autofocus x-on:click="$refs.details.close()" aria-label="Fechar descrição" class="-mr-2 -mt-2 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full text-slate-500 hover:bg-stone-100 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#006c94]">
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="m5 5 10 10M5 15 15 5" stroke-linecap="round" /></svg>
                                </button>
                            </div>

                            @if ($product->description)
                                <p class="mb-0 mt-5 text-left text-base font-normal leading-relaxed text-slate-600">{{ $product->description }}</p>
                            @endif

                            <fieldset class="mt-6 space-y-3">
                                <legend class="mb-3 text-sm font-semibold text-slate-800">
                                    {{ $product->variants->count() > 1 ? 'Escolha as quantidades' : 'O que está incluído' }}
                                </legend>
                                @foreach ($product->variants as $variant)
                                    <div
                                        class="rounded-xl border p-4 transition-colors motion-reduce:transition-none"
                                        x-bind:class="quantities[@js((string) $variant->id)] > 0 ? 'border-[#006c94] bg-sky-50/50' : 'border-stone-200 bg-stone-50'"
                                    >
                                        <div class="flex flex-wrap items-center justify-between gap-3">
                                            <div>
                                                <span class="block text-sm font-semibold text-slate-800">{{ $variant->label }}</span>
                                                <span class="mt-1 block whitespace-nowrap text-sm tabular-nums text-slate-600">{{ number_format($variant->price, 2, ',', ' ') }} € / un.</span>
                                            </div>
                                            <x-shop.quantity-selector
                                                :id="'modal-quantity-'.$product->id.'-'.$variant->id"
                                                :product-name="$product->name.' — '.$variant->label"
                                                :variant-id="$variant->id"
                                                :show-label="false"
                                            />
                                        </div>
                                        @if ($variant->description)
                                            <p class="mb-0 mt-3 text-left text-sm font-normal leading-relaxed text-slate-600">{{ $variant->description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </fieldset>
                            <div class="mt-6 flex flex-wrap items-end justify-between gap-4 border-t border-stone-100 pt-5">
                                <span class="text-sm text-slate-500" x-text="unitCount + (unitCount === 1 ? ' unidade' : ' unidades')"></span>
                                <div class="text-right">
                                    <span class="mb-1 block text-xs text-slate-500">Total</span>
                                    <span aria-live="polite" aria-atomic="true" x-text="totalPrice" class="whitespace-nowrap text-2xl font-semibold tabular-nums text-slate-900">0,00 €</span>
                                </div>
                            </div>
                            <button type="button" x-on:click="$refs.details.close()" class="mt-5 inline-flex min-h-11 w-full items-center justify-center rounded-lg bg-[#006c94] px-4 text-sm font-semibold text-white hover:bg-[#005575] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#006c94]">Confirmar seleção</button>
                            <p class="mb-0 mt-5 text-left text-xs font-normal text-slate-400">Imagem ilustrativa.</p>
                        </div>
                    </dialog>
                </article>
            @empty
                <div class="rounded-xl border border-dashed border-stone-300 bg-white px-6 py-12 text-center sm:col-span-2">
                    <h2 class="m-0 text-lg font-semibold text-slate-900">Ainda não há produtos disponíveis</h2>
                    <p class="mb-0 mt-2 text-center text-sm font-normal text-slate-600">Volte em breve para descobrir outras formas de ajudar.</p>
                </div>
            @endforelse
        </div>
        @if ($this->products->isNotEmpty())
            <x-shop.purchase-bar class="mt-6" />

            {{--
                wire:ignore.self protege os atributos DESTE elemento, não o
                conteúdo. O showModal() do Alpine acrescenta "open" ao
                diálogo; o servidor nunca escreve esse atributo, por isso o
                Livewire removia-o a cada actualização e o modal fechava.
                O interior continua a ser actualizado — é o que faz os
                passos mudarem.
            --}}
            <dialog
                wire:ignore.self
                x-ref="cart"
                id="shop-selection"
                aria-labelledby="shop-selection-title"
                x-on:click.self="$el.close()"
                x-on:close="document.body.style.overflow = cartOverflow"
                class="m-auto max-h-[90dvh] w-[calc(100%-2rem)] max-w-4xl overflow-y-auto rounded-2xl border-0 bg-white p-6 text-slate-900 shadow-2xl backdrop:bg-slate-950/50 backdrop:backdrop-blur-sm sm:p-8"
            >
                <div class="flex items-start justify-between gap-4">
                    <h2 id="shop-selection-title" class="m-0 text-2xl font-semibold tracking-tight">Finalizar contributo</h2>
                    <button type="button" autofocus x-on:click="$refs.cart.close()" aria-label="Fechar seleção" class="-mr-2 -mt-2 inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full text-slate-500 hover:bg-stone-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#006c94]">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="m5 5 10 10M5 15 15 5" stroke-linecap="round" /></svg>
                    </button>
                </div>
                @if ($step === 1)
                <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.15fr)]">

                    {{-- Esquerda: o resumo, com os valores que o servidor
                         repreçou. É o único total no ecrã. --}}
                    <div class="lg:border-r lg:border-stone-100 lg:pr-8">
                        <h3 class="m-0 text-sm font-semibold text-slate-800">A sua seleção</h3>

                        <ul class="m-0 mt-3 list-none divide-y divide-stone-100 p-0">
                            @foreach ($lines as $line)
                                <li class="flex items-center justify-between gap-3 py-3">
                                    <span class="text-sm text-slate-600">
                                        {{ $line['quantity'] }} × {{ $line['product_name'] }}
                                        <span class="block text-xs text-slate-500">{{ $line['variant_label'] }}</span>
                                    </span>
                                    <span class="whitespace-nowrap text-sm font-semibold tabular-nums">
                                        {{ number_format($line['unit_price'] * $line['quantity'], 2, ',', ' ') }} €
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-3 flex items-center justify-between border-t border-stone-200 pt-4">
                            <span class="font-medium">Total</span>
                            <span class="text-2xl font-semibold tabular-nums">{{ number_format($this->total, 2, ',', ' ') }} €</span>
                        </div>

                        <button
                            type="button"
                            x-on:click="$refs.cart.close()"
                            class="mt-5 inline-flex min-h-11 w-full items-center justify-center rounded-lg border border-stone-200 px-4 text-sm font-semibold hover:bg-stone-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-[#006c94]"
                        >
                            Alterar seleção
                        </button>
                    </div>

                    {{-- Direita: os dados de quem contribui. --}}
                    <div>
                        <form wire:submit="placeOrder">
                        <fieldset>
                            <legend class="mb-3 text-sm font-semibold text-slate-800">Os seus dados</legend>

                            <div class="space-y-4">
                                <div>
                                    <label for="buyer_name" class="block text-sm font-medium text-slate-700">Nome</label>
                                    <input id="buyer_name" type="text" wire:model="buyer_name" autocomplete="name"
                                        @error('buyer_name') aria-invalid="true" aria-describedby="buyer_name_erro" @enderror
                                        class="mt-1 block min-h-11 w-full rounded-lg border-stone-300 text-sm focus:border-[#006c94] focus:ring-[#006c94]">
                                    @error('buyer_name')
                                        <p id="buyer_name_erro" class="mb-0 mt-1 text-left text-sm text-red-700">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="buyer_email" class="block text-sm font-medium text-slate-700">Email</label>
                                    <input id="buyer_email" type="email" wire:model="buyer_email" autocomplete="email"
                                        @error('buyer_email') aria-invalid="true" aria-describedby="buyer_email_erro" @enderror
                                        class="mt-1 block min-h-11 w-full rounded-lg border-stone-300 text-sm focus:border-[#006c94] focus:ring-[#006c94]">
                                    @error('buyer_email')
                                        <p id="buyer_email_erro" class="mb-0 mt-1 text-left text-sm text-red-700">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="buyer_phone" class="block text-sm font-medium text-slate-700">Telemóvel MB Way</label>
                                    <div class="mt-1 flex min-h-11 w-full items-stretch overflow-hidden rounded-lg border border-stone-300 focus-within:border-[#006c94] focus-within:ring-1 focus-within:ring-[#006c94]">
                                        <span class="flex select-none items-center border-r border-stone-300 bg-stone-50 px-3 text-sm font-medium text-slate-500">+351</span>
                                        <input id="buyer_phone" type="tel" inputmode="numeric" wire:model="buyer_phone" autocomplete="tel-national"
                                            aria-describedby="buyer_phone_ajuda @error('buyer_phone') buyer_phone_erro @enderror"
                                            @error('buyer_phone') aria-invalid="true" @enderror
                                            class="block w-full border-0 bg-transparent px-3 text-sm focus:ring-0">
                                    </div>
                                    <p id="buyer_phone_ajuda" class="mb-0 mt-1 text-left text-xs text-slate-500">
                                        É para aqui que vai o pedido de pagamento. O MB Way só funciona com
                                        números portugueses: nove dígitos, começado em 91, 92, 93 ou 96.
                                    </p>
                                    @error('buyer_phone')
                                        <p id="buyer_phone_erro" class="mb-0 mt-1 text-left text-sm text-red-700">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="mt-6">
                            <legend class="mb-1 text-sm font-semibold text-slate-800">Para o recibo</legend>
                            <p class="mb-3 mt-0 text-left text-xs text-slate-500">Opcional. Preencha se quiser recibo com os seus dados.</p>

                            <div class="space-y-4">
                                <div>
                                    <label for="tax_number" class="block text-sm font-medium text-slate-700">NIF</label>
                                    <input id="tax_number" type="text" inputmode="numeric" wire:model="tax_number"
                                        @error('tax_number') aria-invalid="true" aria-describedby="tax_number_erro" @enderror
                                        class="mt-1 block min-h-11 w-full rounded-lg border-stone-300 text-sm focus:border-[#006c94] focus:ring-[#006c94]">
                                    @error('tax_number')
                                        <p id="tax_number_erro" class="mb-0 mt-1 text-left text-sm text-red-700">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="address_line" class="block text-sm font-medium text-slate-700">Morada</label>
                                    <input id="address_line" type="text" wire:model="address_line" autocomplete="street-address"
                                        class="mt-1 block min-h-11 w-full rounded-lg border-stone-300 text-sm focus:border-[#006c94] focus:ring-[#006c94]">
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label for="postal_code" class="block text-sm font-medium text-slate-700">Código postal</label>
                                        <input id="postal_code" type="text" wire:model="postal_code" placeholder="4700-123" autocomplete="postal-code"
                                            @error('postal_code') aria-invalid="true" aria-describedby="postal_code_erro" @enderror
                                            class="mt-1 block min-h-11 w-full rounded-lg border-stone-300 text-sm focus:border-[#006c94] focus:ring-[#006c94]">
                                        @error('postal_code')
                                            <p id="postal_code_erro" class="mb-0 mt-1 text-left text-sm text-red-700">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-slate-700">Localidade</label>
                                        <input id="city" type="text" wire:model="city" autocomplete="address-level2"
                                            class="mt-1 block min-h-11 w-full rounded-lg border-stone-300 text-sm focus:border-[#006c94] focus:ring-[#006c94]">
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="mt-6 space-y-3 border-t border-stone-100 pt-5">
                            <label class="flex items-start gap-3 text-sm text-slate-700">
                                <input type="checkbox" wire:model="is_anonymous" class="mt-0.5 h-5 w-5 rounded border-stone-300 text-[#006c94] focus:ring-[#006c94]">
                                <span>Não quero aparecer na lista pública de contributos</span>
                            </label>

                            <div>
                                <label class="flex items-start gap-3 text-sm text-slate-700">
                                    <input type="checkbox" wire:model="terms" class="mt-0.5 h-5 w-5 rounded border-stone-300 text-[#006c94] focus:ring-[#006c94]"
                                        @error('terms') aria-invalid="true" aria-describedby="terms_erro" @enderror>
                                    <span>Aceito a <a href="{{ route('privacy') }}" target="_blank" class="underline decoration-stone-300 underline-offset-4 hover:text-[#006c94]">política de privacidade</a></span>
                                </label>
                                @error('terms')
                                    <p id="terms_erro" class="mb-0 ml-8 mt-1 text-left text-sm text-red-700">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row">
                            <button type="button" wire:click="$set('step', 1)"
                                class="inline-flex min-h-11 flex-1 items-center justify-center rounded-lg border border-stone-200 px-4 text-sm font-semibold hover:bg-stone-50">
                                Voltar
                            </button>

                            {{-- O valor no botão: é a última coisa lida antes
                                 de sair dinheiro da conta. --}}
                            <button type="submit" wire:loading.attr="disabled" wire:target="placeOrder"
                                class="inline-flex min-h-11 flex-[2] items-center justify-center rounded-lg bg-[#006c94] px-4 text-sm font-semibold text-white hover:bg-[#005575] disabled:cursor-wait disabled:opacity-60">
                                <span wire:loading.remove wire:target="placeOrder">
                                    Pagar {{ number_format($this->total, 2, ',', ' ') }} € com MB Way
                                </span>
                                <span wire:loading wire:target="placeOrder">A contactar o MB Way…</span>
                            </button>
                        </div>
                    </form>
                    </div>
                </div>

                @elseif ($step === 2)
                    {{--
                        O wire:poll vive DENTRO deste bloco de propósito:
                        quando o passo mudar para 3, o elemento desaparece e o
                        polling pára sozinho. Fora daqui, continuaria a
                        perguntar para sempre.
                    --}}
                    <div wire:poll.5s="checkPayment" class="py-8 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-sky-50">
                            <svg class="h-8 w-8 animate-spin text-[#006c94] motion-reduce:animate-none" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2.5" opacity="0.2" />
                                <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" />
                            </svg>
                        </div>

                        <h3 class="m-0 mt-5 text-lg font-semibold text-slate-900">Confirme no seu telemóvel</h3>

                        {{-- O valor e o número à vista: é aqui que a pessoa
                             se apercebe se escreveu o telemóvel errado, em vez
                             de esperar quatro minutos por nada. --}}
                        <p class="mx-auto mb-0 mt-3 max-w-sm text-center text-sm font-normal leading-relaxed text-slate-600">
                            Enviámos um pedido de <strong class="font-semibold text-slate-900">{{ number_format($this->total, 2, ',', ' ') }} €</strong>
                            para o <strong class="font-semibold text-slate-900">{{ $buyer_phone }}</strong>.
                            Abra a aplicação MB Way e confirme.
                        </p>

                        <p role="status" class="mb-0 mt-5 text-center text-xs font-normal text-slate-500">
                            O pedido expira em 4 minutos. Esta página actualiza-se sozinha.
                        </p>
                    </div>

                @elseif ($step === 3)
                    @php($status = $this->payment?->status)

                    <div class="py-8 text-center">
                        @if ($status === \App\Models\Payment::STATUS_PAID)
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50">
                                <svg class="h-8 w-8 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m5 13 4 4L19 7" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            </div>
                            <h3 class="m-0 mt-5 text-lg font-semibold text-slate-900">Obrigado pelo seu contributo</h3>
                            <p class="mx-auto mb-0 mt-3 max-w-sm text-center text-sm font-normal leading-relaxed text-slate-600">
                                O pagamento de {{ number_format($this->total, 2, ',', ' ') }} € foi confirmado.
                                Enviámos a confirmação para {{ $buyer_email }}.
                            </p>
                            <p class="mb-0 mt-3 text-center text-xs font-normal text-slate-500">
                                Referência: {{ $this->payment?->payable?->access_code }}
                            </p>

                        @elseif ($status === \App\Models\Payment::STATUS_EXPIRED)
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-amber-50">
                                <svg class="h-8 w-8 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 7v5l3 2M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            </div>
                            <h3 class="m-0 mt-5 text-lg font-semibold text-slate-900">O pedido expirou</h3>
                            {{-- Expirar não é recusar: ninguém disse que não,
                                 a pessoa só não chegou a tempo. Por isso convida. --}}
                            <p class="mx-auto mb-0 mt-3 max-w-sm text-center text-sm font-normal leading-relaxed text-slate-600">
                                Passaram os 4 minutos sem confirmação. Nada foi cobrado.
                            </p>
                            <button type="button" wire:click="retry"
                                class="mt-6 inline-flex min-h-11 items-center justify-center rounded-lg bg-[#006c94] px-5 text-sm font-semibold text-white hover:bg-[#005575]">
                                Tentar de novo
                            </button>

                        @elseif ($status === \App\Models\Payment::STATUS_REJECTED)
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-stone-100">
                                <svg class="h-8 w-8 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m8 8 8 8M16 8l-8 8" stroke-linecap="round" /></svg>
                            </div>
                            <h3 class="m-0 mt-5 text-lg font-semibold text-slate-900">Pagamento recusado</h3>
                            {{-- Repetir é seguro porque temos a certeza de que
                                 nada foi cobrado. Pode ter sido um toque errado
                                 na app, ou saldo que entretanto se resolve. --}}
                            <p class="mx-auto mb-0 mt-3 max-w-sm text-center text-sm font-normal leading-relaxed text-slate-600">
                                O pagamento não foi autorizado e nada foi cobrado.
                                Pode tentar de novo.
                            </p>
                            <button type="button" wire:click="retry"
                                class="mt-6 inline-flex min-h-11 items-center justify-center rounded-lg bg-[#006c94] px-5 text-sm font-semibold text-white hover:bg-[#005575]">
                                Tentar de novo
                            </button>

                        @elseif ($status === \App\Models\Payment::STATUS_FAILED)
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-stone-100">
                                <svg class="h-8 w-8 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 9v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            </div>
                            <h3 class="m-0 mt-5 text-lg font-semibold text-slate-900">Não foi possível iniciar o pagamento</h3>
                            {{-- Aqui a ifthenpay respondeu e recusou criar:
                                 temos a certeza de que nada foi criado, por
                                 isso repetir é seguro. --}}
                            <p class="mx-auto mb-0 mt-3 max-w-sm text-center text-sm font-normal leading-relaxed text-slate-600">
                                O pedido não chegou a ser criado e nada foi cobrado.
                                Confirme o número de telemóvel e tente de novo.
                            </p>
                            <button type="button" wire:click="retry"
                                class="mt-6 inline-flex min-h-11 items-center justify-center rounded-lg bg-[#006c94] px-5 text-sm font-semibold text-white hover:bg-[#005575]">
                                Tentar de novo
                            </button>

                        @else
                            {{-- unknown, ou um estado que não reconhecemos.
                                 Nunca dizer que falhou: o pedido pode existir e
                                 ter sido aprovado. Sem botão de repetir —
                                 reenviar criaria uma segunda cobrança. --}}
                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-sky-50">
                                <svg class="h-8 w-8 text-[#006c94]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            </div>
                            <h3 class="m-0 mt-5 text-lg font-semibold text-slate-900">Estamos a confirmar</h3>
                            <p class="mx-auto mb-0 mt-3 max-w-sm text-center text-sm font-normal leading-relaxed text-slate-600">
                                Não conseguimos confirmar de imediato. Verifique a aplicação MB Way:
                                se o pagamento aparecer lá, está tratado e receberá confirmação por email.
                            </p>
                            <p class="mx-auto mb-0 mt-3 max-w-sm text-center text-xs font-normal text-slate-500">
                                Não repita o pagamento sem falar connosco — poderia ser cobrado duas vezes.
                            </p>
                        @endif

                        <button type="button" x-on:click="$refs.cart.close()"
                            class="mt-6 inline-flex min-h-11 w-full items-center justify-center rounded-lg border border-stone-200 px-4 text-sm font-semibold hover:bg-stone-50">
                            Fechar
                        </button>
                    </div>
                @endif
            </dialog>
        @endif
    </div>
</section>
