{{--
    FILE: resources/views/livewire/campaigns/christmas25/recent-donations.blade.php
    CONTEXT: Displays a scrollable list of the latest 50 paid donations.
             It updates in real-time when a new donation is confirmed.
--}}

<?php

use App\Models\Donation;
use Illuminate\Support\Carbon;
use function Livewire\Volt\{state, mount, on};

// -----------------------------------------------------------------------------
// STATE
// -----------------------------------------------------------------------------

state([
    'donations' => [],
]);

// -----------------------------------------------------------------------------
// LOGIC
// -----------------------------------------------------------------------------

/**
 * Fetch the latest 50 PAID donations from the database.
 */
$loadDonations = function () {
    $this->donations = Donation::where('payment_status', 'paid')
        ->orderByDesc('created_at')
        ->take(50)
        ->get()
        ->toArray();
};

/**
 * Initial load.
 */
mount(function () {
    $this->loadDonations();
});

/**
 * Event Listener: 'donation-added'
 * Triggered when a payment is successfully processed in the modal.
 * Reloads the list to show the new donor immediately.
 */
on(['donation-added' => function () {
    $this->loadDonations();
}]);

?>

<div class="space-y-2">
    @forelse ($donations as $donation)
        {{-- CARD ITEM --}}
        <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-emerald-100 shadow-sm transition-all hover:border-emerald-200 hover:shadow-md">

            {{--
                AVATAR COLUMN
                Shows an icon for anonymous donors or the first letter of the name.
            --}}
            <div class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-100">
                @if($donation['is_anonymous'] ?? false)
                    {{-- Anonymous Icon --}}
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                @else
                    {{-- Initial Letter --}}
                    {{ strtoupper(substr($donation['donor_name'], 0, 1)) }}
                @endif
            </div>

            {{-- CONTENT COLUMN --}}
            <div class="flex-1 min-w-0">

                {{-- Header: Name & Time --}}
                <div class="flex justify-between items-start gap-2">
                    <p class="font-semibold text-sm text-neutral-800 leading-tight truncate">
                        @if($donation['is_anonymous'] ?? false)
                            <span class="italic text-neutral-500">Benfeitor Anónimo</span>
                        @else
                            {{ $donation['donor_name'] }}
                        @endif
                    </p>

                    {{-- Relative Time (e.g., "5 min ago") --}}
                    <span class="text-[10px] text-neutral-400 shrink-0 whitespace-nowrap pt-0.5">
                        {{ \Carbon\Carbon::parse($donation['created_at'])->diffForHumans() }}
                    </span>
                </div>

                {{-- Public Message (Quote) --}}
                @if (isset($donation['public_message']) && !empty($donation['public_message']))
                    <div class="mt-2 text-xs text-neutral-600 bg-emerald-50/50 p-2 rounded-lg border border-emerald-50 italic relative">
                        <span class="absolute -top-1 left-2 text-emerald-200 text-xl leading-none">“</span>
                        <span class="relative z-10">{{ $donation['public_message'] }}</span>
                    </div>
                @endif

                {{-- Gift Badge --}}
                @if ($donation['is_gift'] ?? false)
                    <div class="mt-2 flex items-center gap-1.5 text-[10px] text-emerald-600 font-medium bg-emerald-50/50 w-fit px-2 py-0.5 rounded-full">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                        </svg>
                        <span>Oferta de Natal</span>
                    </div>
                @endif
            </div>

            {{-- AMOUNT COLUMN --}}
            <div class="shrink-0 font-bold text-xs text-emerald-700 bg-emerald-100/50 px-2 py-1 rounded-md border border-emerald-100 h-fit">
                {{ number_format($donation['amount'], 0, ',', '.') }}€
            </div>

        </div>
    @empty
        {{-- EMPTY STATE --}}
        <div class="flex flex-col items-center justify-center py-12 text-center space-y-3">
            <div class="w-12 h-12 bg-neutral-50 rounded-full flex items-center justify-center text-2xl grayscale opacity-50">
                🎄
            </div>
            <div class="text-neutral-400 text-xs">
                <p>Ainda não há donativos.</p>
                <p>Sê o primeiro a acender a árvore!</p>
            </div>
        </div>
    @endforelse
</div>
