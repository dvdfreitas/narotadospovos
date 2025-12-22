<?php

use App\Models\Donation;
use function Livewire\Volt\{state, layout, mount, title};

layout('layouts.guest');
title('O teu Postal de Natal - Na Rota dos Povos');

state([
    'donation',
    'view', // 'donor' | 'gift'
]);

mount(function ($code) {
    $this->donation = Donation::where('access_code', $code)->firstOrFail();
    
    /**
     * Determine if we are showing the card for the donor or the recipient.
     * Default to 'gift' if it's a gift donation.
     */
    $this->view = request()->query('view', 'gift');
});

?>

@php
    $donation = $donation;

    // Data extraction from the JSON field
    $isGift = (bool) data_get($donation->campaign_data, 'is_gift', false);
    $recipientName = (string) data_get($donation->campaign_data, 'gift_recipient_name', '');
    $giftMessage = data_get($donation->campaign_data, 'gift_message');
    $publicMessage = data_get($donation->campaign_data, 'public_message');
    
    $itemType = (string) data_get($donation->campaign_data, 'item_type', 'custom');

    // Display logic for donor name
    $donorDisplay = $donation->is_anonymous ? 'um(a) amigo(a)' : $donation->donor_name;

    // View normalization
    $view = in_array($view, ['donor','gift'], true) ? $view : 'gift';
    $isGiftView = ($view === 'gift') && $isGift;

    // Item Mapping for the stamp
    $itemMap = [
        'papas'   => ['emoji' => '🥣', 'label' => 'Papas Quentes'],
        'leite'   => ['emoji' => '🍼', 'label' => 'Leite Bebé'],
        'crianca' => ['emoji' => '🧸', 'label' => 'Cabaz Criança'],
        'familia' => ['emoji' => '❤️', 'label' => 'Cabaz Família'],
        'custom'  => ['emoji' => '🎄', 'label' => 'Donativo Livre'],
    ];

    $item = $itemMap[$itemType] ?? $itemMap['custom'];
@endphp

<div>
    {{-- FONTS --}}
    @assets
        <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Kalam:wght@300;400;700&family=Mountains+of+Christmas:wght@400;700&display=swap" rel="stylesheet">
    @endassets

    {{-- STYLES --}}
    <style>
        .font-typewriter { font-family: 'Courier Prime', monospace; }
        .font-handwriting { font-family: 'Kalam', cursive; }
        .font-festive { font-family: 'Mountains of Christmas', cursive; }

        .text-xmas-red { color: #c30f16; }
        .bg-xmas-red { background-color: #c30f16; }
        .text-xmas-green { color: #165b33; }
        .bg-xmas-green { background-color: #165b33; }
        .text-ink { color: #3d312b; }
        .text-ink-light { color: #8c7b70; }

        .airmail-pattern {
            background-color: #fdfbf7;
            background-image: repeating-linear-gradient(
                135deg, #c30f16 0px, #c30f16 20px, #fdfbf7 20px, #fdfbf7 40px, #165b33 40px, #165b33 60px, #fdfbf7 60px, #fdfbf7 80px
            );
        }

        .paper-texture {
            background-color: #fffdf7;
            background-image: url("https://www.transparenttextures.com/patterns/cream-paper.png");
        }
        
        .stamp-border {
            background: radial-gradient(transparent 0px, transparent 4px, white 4px, white);
            background-size: 10px 10px;
            background-position: -5px -5px;
            padding: 5px;
        }

        /* --- PRINT ENGINE (Total Isolation) --- */
        @media print {
            @page { margin: 0; size: landscape; }
            
            /* Hide external layout elements like site footers/headers */
            html, body { height: 100vh; overflow: hidden !important; background: white !important; }
            body > *:not(.min-h-screen) { display: none !important; }
            .min-h-screen > *:not(.printable-area-wrapper) { display: none !important; }
            
            /* Center the postal on the A4 page */
            .printable-area-wrapper {
                position: fixed !important;
                top: 0 !important; left: 0 !important;
                width: 100vw !important; height: 100vh !important;
                display: flex !important; align-items: center !important; justify-content: center !important;
                padding: 50px !important; margin: 0 !important;
                visibility: visible !important; z-index: 9999 !important;
                background-color: white !important;
            }
            .printable-area-wrapper * { visibility: visible !important; }
            .no-print { display: none !important; }

            /* Flatten design for paper */
            .airmail-pattern { transform: none !important; box-shadow: none !important; width: 100% !important; border: 1px solid #eee !important; }
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        }
    </style>

    <div class="min-h-screen py-6 sm:py-12 bg-amber-50/50 flex items-center justify-center px-2 sm:px-4 font-sans print:bg-white print:py-0">
        
        <div class="printable-area-wrapper w-full max-w-5xl relative">
            
            <div class="airmail-pattern p-2 sm:p-4 shadow-2xl transform md:-rotate-1 transition-transform duration-700 md:group-hover:rotate-0 print:transform-none">
                
                <div class="paper-texture w-full min-h-[600px] relative grid grid-cols-1 md:grid-cols-2 shadow-inner">
                    {{-- Vertical Divider (Desktop) --}}
                    <div class="hidden md:block absolute left-1/2 top-8 bottom-8 w-px bg-ink-light opacity-30"></div>

                    {{-- LEFT COLUMN: MESSAGE --}}
                    <div class="p-6 sm:p-10 md:p-14 flex flex-col justify-center order-2 md:order-1">
                        <div class="font-handwriting text-xl sm:text-2xl text-ink leading-relaxed">

                            @if ($isGiftView)
                                {{-- === POSTAL PARA O DESTINATÁRIO === --}}
                                <p class="mb-4 font-bold text-xmas-red font-festive text-3xl">Olá{{ $recipientName ? ' ' . $recipientName : '' }},</p>
                                <p class="mb-4">Tenho uma surpresa especial para ti! 🎁</p>
                                <p class="mb-4">
                                    O/A <strong class="text-xmas-green bg-green-50/50 px-1 rounded">{{ $donorDisplay }}</strong>
                                    ofereceu uma <strong>prenda solidária</strong> em teu nome para apoiar as crianças da Casa da Mamé.
                                </p>

                                @if ($giftMessage)
                                    <div class="my-6">
                                        {{-- CONTEXTO DA MENSAGEM --}}
                                        <p class="text-[11px] text-ink-light font-sans mb-1 uppercase tracking-widest font-bold opacity-70 italic">
                                            E deixou-te ainda esta mensagem especial:
                                        </p>
                                        <div class="relative pl-4 border-l-4 border-xmas-red/30 italic">
                                            "{{ $giftMessage }}"
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-8">
                                    <p class="text-lg text-ink-light font-sans mb-1">Boas Festas,</p>
                                    <p class="text-2xl font-bold text-xmas-green font-festive leading-none">Na Rota dos Povos</p>
                                </div>
                            @else
                                {{-- === POSTAL PARA O DOADOR === --}}
                                <p class="mb-6 font-bold text-xmas-red font-festive text-3xl">Caro(a) {{ $donation->donor_name }},</p>
                                <p class="mb-4">A equipa da <strong class="text-xmas-green">Na Rota dos Povos</strong> agradece o teu gesto de imensa generosidade.</p>
                                <p class="mb-6">Este postal simboliza a esperança que ajudaste a semear na Guiné-Bissau. A tua bola já brilha na árvore!</p>

                                @if ($isGift && $giftMessage)
                                    <div class="my-8">
                                        <p class="text-[10px] text-ink-light font-sans mb-2 uppercase tracking-wide font-bold opacity-60">
                                            A tua dedicatória para {{ $recipientName ?: 'o destinatário' }}:
                                        </p>
                                        <div class="relative pl-4 border-l-4 border-xmas-red/20 italic font-handwriting text-lg text-xmas-red/90">
                                            "{{ $giftMessage }}"
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-auto text-right pt-8">
                                    <p class="text-lg text-ink-light font-sans mb-1">Com gratidão,</p>
                                    <p class="text-2xl font-bold text-xmas-green font-festive leading-none">A Direção</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: ADDRESS & STAMP --}}
                    <div class="p-6 sm:p-10 md:p-12 flex flex-col order-1 md:order-2 border-b md:border-b-0 border-gray-200 relative">
                        
                        {{-- Top Stamp Area --}}
                        <div class="flex justify-between items-start mb-8 sm:mb-16">
                            <div class="pt-2 opacity-50 hidden sm:block">
                                <h1 class="font-sans font-bold text-ink-light tracking-[0.35em] text-lg uppercase select-none">Via Aérea</h1>
                            </div>
                            
                            <div class="flex items-center gap-4 justify-end w-full sm:w-auto">
                                {{-- Round Postmark --}}
                                <div class="hidden sm:flex flex-col items-center justify-center w-24 h-24 rounded-full border-2 border-ink-light text-ink-light rotate-[-12deg] absolute -left-20 top-2 opacity-60 mix-blend-multiply pointer-events-none font-typewriter">
                                    <span class="text-[9px] uppercase tracking-widest font-bold text-center leading-tight">Natal<br>{{ date('Y') }}</span>
                                </div>

                                {{-- Stamp --}}
                                <div class="relative bg-white p-0.5 shadow-md rotate-2 stamp-border">
                                    <div class="w-[80px] h-[95px] bg-amber-50 border border-amber-100/50 flex flex-col items-center justify-center overflow-hidden">
                                        <div class="absolute top-0 right-0 w-8 h-8 bg-xmas-red transform rotate-45 translate-x-4 -translate-y-4"></div>
                                        <div class="text-4xl mb-1 mt-2">{{ $item['emoji'] }}</div>
                                        <span class="text-[9px] font-bold text-xmas-green uppercase tracking-wide px-1 mt-1 text-center leading-tight">{{ $item['label'] }}</span>
                                        @if (!$isGiftView)
                                            <span class="absolute bottom-1 font-mono font-bold text-xmas-red text-xs border-t border-amber-200/60 w-full text-center pt-0.5">{{ number_format($donation->amount, 0) }} €</span>
                                        @else
                                            <span class="absolute bottom-1 font-bold text-[8px] text-xmas-red w-full text-center uppercase tracking-wider opacity-80">Oferta</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Address Lines --}}
                        <div class="mt-auto space-y-6 font-typewriter text-ink text-lg sm:text-xl pl-0 sm:pl-12">
                            @if ($isGiftView)
                                <div class="border-b border-ink-light/20 pb-2 pt-4 relative">
                                    <span class="text-[9px] text-ink-light absolute top-0 left-0 font-sans uppercase font-bold">Para:</span> {{ $recipientName ?: '—' }}
                                </div>
                                <div class="border-b border-ink-light/20 pb-2 pt-4 relative">
                                    <span class="text-[9px] text-ink-light absolute top-0 left-0 font-sans uppercase font-bold">De:</span> {{ $donorDisplay }}
                                </div>
                            @else
                                <div class="border-b border-ink-light/20 pb-2 pt-4 relative">
                                    <span class="text-[9px] text-ink-light absolute top-0 left-0 font-sans uppercase font-bold">Destino:</span> ONGD NA ROTA DOS POVOS
                                </div>
                                <div class="border-b border-ink-light/20 pb-2">Casa da Mamé</div>
                            @endif
                            <div class="border-b border-ink-light/20 pb-1 flex justify-between items-baseline opacity-70">
                                <span class="text-sm font-sans uppercase tracking-wider">Portugal / Guiné-Bissau</span>
                            </div>
                        </div>
                        
                        {{-- Donativo ID Stamp --}}
                        <div class="absolute bottom-4 right-6 transform -rotate-6 mix-blend-multiply pointer-events-none">
                            <div class="border-2 border-xmas-red rounded-sm px-3 py-1 text-xmas-red font-typewriter flex flex-col items-center">
                                <span class="text-[8px] uppercase font-bold">Donativo Nº</span>
                                <span class="text-base font-bold tracking-widest">{{ $donation->access_code }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACTIONS (HIDDEN IN PRINT) --}}
            <div class="no-print mt-8 text-center space-y-4 px-4">
                <p class="text-sm text-ink-light font-sans">
                    {{ $isGiftView ? 'Partilha este link com a pessoa a quem vais oferecer!' : 'Obrigado por fazeres parte desta história.' }}
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <button onclick="window.print()" class="px-6 py-3 bg-white text-ink font-bold rounded-full shadow-sm border border-slate-200 hover:bg-amber-50 hover:text-xmas-red transition-all flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Imprimir / Guardar
                    </button>
                    <a href="{{ route('christmas.board') }}" class="px-6 py-3 bg-xmas-red text-white font-bold rounded-full shadow-lg hover:bg-red-800 transition-all flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Voltar à Árvore
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>