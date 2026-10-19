@props(['id', 'productName', 'variantId', 'minimum' => 0, 'showLabel' => true])

<div>
    <label for="{{ $id }}" class="{{ $showLabel ? 'mb-1.5 block text-xs font-medium text-slate-500' : 'sr-only' }}">Unidades<span class="sr-only"> de {{ $productName }}</span></label>
    <div class="flex h-11 overflow-hidden rounded-lg border border-stone-200 bg-white">
        <button
            type="button"
            x-on:click="updateQuantity(@js((string) $variantId), quantities[@js((string) $variantId)] - 1)"
            x-bind:disabled="quantities[@js((string) $variantId)] <= {{ $minimum }}"
            aria-label="Diminuir quantidade de {{ $productName }}"
            class="flex w-9 shrink-0 items-center justify-center text-lg text-slate-700 hover:bg-stone-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-[#006c94] disabled:cursor-not-allowed disabled:text-stone-300"
        >−</button>
        <input
            id="{{ $id }}"
            type="number"
            inputmode="numeric"
            min="{{ $minimum }}"
            max="99"
            step="1"
            required
            x-bind:value="quantities[@js((string) $variantId)]"
            x-on:input="if ($el.validity.valid) updateQuantity(@js((string) $variantId), $el.value)"
            x-on:change="updateQuantity(@js((string) $variantId), $el.value); $el.value = quantities[@js((string) $variantId)]"
            x-on:keydown.enter.prevent="$el.blur()"
            class="w-10 min-w-0 appearance-none border-0 bg-transparent p-0 text-center text-sm font-medium tabular-nums text-slate-900 focus:ring-inset focus:ring-[#006c94] [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
        >
        <button
            type="button"
            x-on:click="updateQuantity(@js((string) $variantId), quantities[@js((string) $variantId)] + 1)"
            x-bind:disabled="quantities[@js((string) $variantId)] >= 99"
            aria-label="Aumentar quantidade de {{ $productName }}"
            class="flex w-9 shrink-0 items-center justify-center text-lg text-slate-700 hover:bg-stone-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-[-2px] focus-visible:outline-[#006c94] disabled:cursor-not-allowed disabled:text-stone-300"
        >+</button>
    </div>
</div>
