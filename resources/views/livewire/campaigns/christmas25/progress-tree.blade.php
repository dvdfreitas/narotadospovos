{{--
    FILE: resources/views/livewire/campaigns/christmas25/progress-tree.blade.php
    CONTEXT: The visual centerpiece. Displays a Christmas tree that lights up (gains color)
             as donations progress towards the goal.
--}}

<?php

use App\Models\Donation;
use function Livewire\Volt\{state, computed};

// -----------------------------------------------------------------------------
// STATE MANAGEMENT
// -----------------------------------------------------------------------------

state([
    'goal' => 5000.00,

    // Ornament positions (percentage relative to tree container).
    // Colors refer to standard Tailwind classes.
    'ornaments' => [
        ['top' => 22, 'left' => 48, 'color' => 'text-red-500'],
        ['top' => 35, 'left' => 38, 'color' => 'text-yellow-400'],
        ['top' => 38, 'left' => 58, 'color' => 'text-blue-500'],
        ['top' => 52, 'left' => 32, 'color' => 'text-pink-500'],
        ['top' => 55, 'left' => 52, 'color' => 'text-red-500'],
        ['top' => 50, 'left' => 68, 'color' => 'text-yellow-400'],
        ['top' => 70, 'left' => 25, 'color' => 'text-blue-400'],
        ['top' => 75, 'left' => 45, 'color' => 'text-purple-500'],
        ['top' => 72, 'left' => 65, 'color' => 'text-red-500'],
        ['top' => 65, 'left' => 78, 'color' => 'text-yellow-400'],
    ]
]);

// -----------------------------------------------------------------------------
// COMPUTED PROPERTIES
// -----------------------------------------------------------------------------

$stats = computed(function () {
    // Only count 'paid' donations
    $total = Donation::where('payment_status', 'paid')->sum('amount');

    // Calculate percentage (capped at 100% for the progress bar logic,
    // though the total can go higher in value)
    $percent = $this->goal > 0
        ? min(100, round(($total / $this->goal) * 100))
        : 0;

    return [
        'total'   => $total,
        'percent' => $percent,
        'remain'  => max(0, $this->goal - $total),
        'is_complete' => $total >= $this->goal,
    ];
});

?>

<div wire:poll.5s
     class="relative rounded-3xl border border-emerald-100 bg-gradient-to-b from-emerald-50/80 to-white shadow-sm p-6 flex flex-col overflow-hidden h-full">

    {{--
        SECTION 1: HEADER & STATUS TEXT
    --}}
    <header class="text-center z-10 shrink-0 relative">
        <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-800 mb-2">
            Solidarity Christmas Tree
        </h2>

        <p class="text-sm text-neutral-600 max-w-xs mx-auto leading-relaxed">
            @if($this->stats['is_complete'])
                <span class="font-bold text-emerald-600">Goal Reached! 🌟</span><br>
                Casa da Mamé thanks you!
            @else
                We have raised <span class="font-bold text-emerald-700">{{ number_format($this->stats['total'], 0, ',', '.') }}€</span>
                of the {{ number_format($goal, 0, ',', '.') }}€ goal.
            @endif
        </p>
    </header>

    {{--
        SECTION 2: THE TREE VISUALIZATION
        This is the main graphical area.
    --}}
    <div class="flex-1 relative w-full min-h-0 my-4 group flex items-end justify-center">

        <div class="relative w-full h-full max-w-[400px]">

            {{--
                THE STAR (Top)
                Independent of the masking layers. It animates when goal is reached.
            --}}
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-40 transition-all duration-1000 w-[50px] h-[50px]">
                <svg viewBox="0 0 24 24" fill="currentColor"
                     class="w-full h-full transition-all duration-1000
                     {{ $this->stats['is_complete'] ? 'text-yellow-400 drop-shadow-[0_0_15px_rgba(250,204,21,0.8)] animate-pulse' : 'text-neutral-200' }}">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>

            {{--
                LAYER A: COLORFUL (Background)
                This layer sits at the bottom (z-0). It is the "Goal Reached" state.
            --}}
            <div class="absolute inset-0 z-0">
                {{-- Tree Image --}}
                <img src="/images/funding/christmas2025/tree.png" class="w-full h-full object-contain" alt="Christmas Tree">

                {{-- Colored Ornaments Loop --}}
                @foreach($ornaments as $ball)
                    <div class="absolute w-4 h-4 {{ $ball['color'] }} drop-shadow-md animate-pulse"
                         style="top: {{ $ball['top'] }}%; left: {{ $ball['left'] }}%; animation-duration: {{ rand(2000, 4000) }}ms;">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="14" r="9" /> {{-- Ball Body --}}
                            <rect x="10" y="2" width="4" height="4" rx="1" fill="#525252"/> {{-- Hook --}}
                        </svg>
                        {{-- Reflection highlight --}}
                        <div class="absolute top-2 left-1 w-1 h-1 bg-white rounded-full opacity-50"></div>
                    </div>
                @endforeach
            </div>

            {{--
                LAYER B: GRAYSCALE (Mask)
                This layer sits on top (z-10). It creates the "unfilled" effect.
                We use 'clip-path: inset(...)' to crop this layer from the bottom up,
                revealing the colored layer underneath based on the percentage.
            --}}
            <div class="absolute inset-0 z-10 pointer-events-none transition-all duration-[2000ms] ease-in-out"
                 style="clip-path: inset(0 0 {{ $this->stats['percent'] }}% 0);">

                {{-- Gray Tree Image --}}
                <img src="/images/funding/christmas2025/tree.png" class="w-full h-full object-contain grayscale opacity-90" alt="Gray Tree">

                {{-- Gray Ornaments Loop (Same positions as colored ones) --}}
                @foreach($ornaments as $ball)
                    <div class="absolute w-4 h-4 text-neutral-300"
                         style="top: {{ $ball['top'] }}%; left: {{ $ball['left'] }}%;">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="14" r="9" />
                            <rect x="10" y="2" width="4" height="4" rx="1" fill="#a3a3a3"/>
                        </svg>
                    </div>
                @endforeach
            </div>

            {{--
                DECORATIONS AT THE BASE
                Static SVGs (Gifts, Boxes) to ground the tree visually.
                Z-Index 20 ensures they stay in front of the tree.
            --}}
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full flex justify-center items-end z-20 pointer-events-none pb-2">

                <div class="absolute left-[20%] bottom-3 w-10 h-12 z-10 opacity-90 transform -rotate-12">
                     <svg viewBox="0 0 40 50" fill="none" class="drop-shadow-sm">
                        <rect x="5" y="10" width="30" height="38" rx="2" fill="#cbd5e1"/>
                        <rect x="5" y="18" width="30" height="22" fill="#e2e8f0"/>
                        <rect x="4" y="8" width="32" height="4" rx="1" fill="#94a3b8"/>
                        <path d="M15 25h10" stroke="#94a3b8" stroke-width="2"/>
                    </svg>
                </div>

                <div class="absolute right-[22%] bottom-3 w-12 h-14 z-10 opacity-90 transform rotate-6">
                    <svg viewBox="0 0 50 60" fill="none" class="drop-shadow-sm">
                        <rect x="10" y="10" width="30" height="45" rx="1" fill="#fca5a5"/>
                        <rect x="10" y="25" width="30" height="15" fill="#fecaca"/>
                        <circle cx="25" cy="32" r="5" fill="#fef08a"/>
                    </svg>
                </div>

                <div class="relative -mr-3 z-20 transform -rotate-6">
                    <svg class="w-10 h-10 text-red-600 drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 12v10H4V12h16zm-2-2H6V6h12v4zm-7-6V2h2v2h-2z"/>
                        <rect x="2" y="8" width="20" height="4" rx="1" fill="#fca5a5"/>
                        <rect x="4" y="12" width="16" height="10" rx="1" fill="#ef4444"/>
                        <rect x="11" y="8" width="2" height="14" fill="#fee2e2"/>
                    </svg>
                </div>

                <div class="relative z-30 mb-1">
                    <svg class="w-14 h-14 text-emerald-600 drop-shadow-lg" fill="none" viewBox="0 0 24 24">
                        <rect x="3" y="8" width="18" height="4" rx="1" fill="#6ee7b7"/>
                        <rect x="5" y="12" width="14" height="10" rx="1" fill="#059669"/>
                        <path d="M12 8V22" stroke="#d1fae5" stroke-width="3"/>
                        <path d="M12 8C12 8 8 3 6 5C4 7 12 8 12 8Z" fill="#a7f3d0"/>
                        <path d="M12 8C12 8 16 3 18 5C20 7 12 8 12 8Z" fill="#a7f3d0"/>
                    </svg>
                </div>

                <div class="relative -ml-3 z-20 transform rotate-3">
                    <svg class="w-9 h-9 text-blue-600 drop-shadow-md" fill="none" viewBox="0 0 24 24">
                        <rect x="3" y="9" width="18" height="3" rx="0.5" fill="#93c5fd"/>
                        <rect x="5" y="12" width="14" height="9" rx="0.5" fill="#2563eb"/>
                        <rect x="11" y="9" width="2" height="12" fill="#dbeafe"/>
                    </svg>
                </div>
            </div>

        </div>
    </div>

    {{--
        SECTION 3: FOOTER PROGRESS BAR
    --}}
    <div class="shrink-0 z-20 bg-white/90 backdrop-blur-sm p-4 rounded-2xl border border-emerald-100/50 mx-auto w-full max-w-sm shadow-sm mt-auto">

        <div class="flex justify-between items-end mb-2">
            <span class="text-[10px] uppercase tracking-widest text-neutral-500 font-medium">Progress</span>
            <div class="text-right">
                <span class="text-2xl font-bold text-emerald-700 leading-none">{{ $this->stats['percent'] }}%</span>
            </div>
        </div>

        {{-- Bar Track --}}
        <div class="w-full bg-neutral-100 rounded-full h-3 mb-1 overflow-hidden border border-neutral-100 relative">
            {{-- Bar Fill --}}
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-3 rounded-full transition-all duration-[2000ms] ease-out relative"
                 style="width: {{ $this->stats['percent'] }}%">
                 <div class="absolute inset-0 bg-white/20"></div>
            </div>
        </div>

        <p class="mt-2 text-[10px] text-center text-neutral-400">
            @if(!$this->stats['is_complete'])
                Only <strong>{{ number_format($this->stats['remain'], 0, ',', '.') }}€</strong> left to light the star.
            @else
                Goal accomplished! Thank you! ❤️
            @endif
        </p>
    </div>

</div>
