<?php

use App\Models\Donation;
use function Livewire\Volt\{state, layout, mount};

// 1. Define the layout for this page
layout('layouts.guest');

// 2. Define component state
state(['donation']);

// 3. Mount lifecycle: Fetch donation by code or 404
mount(function ($code) {
    $this->donation = Donation::where('access_code', $code)->firstOrFail();
});

?>

<div>
    {{-- ASSETS & STYLES --}}
    @assets
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Kalam:wght@300;400;700&display=swap" rel="stylesheet">
    @endassets

    <style>
        /* Typography */
        .font-typewriter { font-family: 'Courier Prime', monospace; }
        .font-handwriting { font-family: 'Kalam', cursive; }

        /* Airmail Border Logic */
        .airmail-border {
            background-color: #fff;
            background-image: repeating-linear-gradient(
                135deg,
                #ef4444 0px, #ef4444 25px,
                #ffffff 25px, #ffffff 45px,
                #0369a1 45px, #0369a1 70px,
                #ffffff 70px, #ffffff 90px
            );
            padding: 15px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Realistic Paper Texture */
        .postcard-paper {
            background-color: #fdfbf7;
            background-image: url("https://www.transparenttextures.com/patterns/cream-paper.png");
            position: relative;
        }

        /* Postmark Stamp */
        .postmark-ring {
            border: 2px solid rgba(100, 100, 100, 0.3);
            color: rgba(100, 100, 100, 0.5);
            mask-image: url("https://www.transparenttextures.com/patterns/dust.png");
        }

        /* Postage Stamp CSS Trick */
        .postage-stamp {
            position: relative;
            background: white;
            filter: drop-shadow(1px 1px 2px rgba(0,0,0,0.3));
        }
        .postage-stamp::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border: 4px dashed #e5e7eb;
            pointer-events: none;
        }
    </style>

    <div class="min-h-screen py-8 md:py-12 flex items-center justify-center bg-gray-100 px-4 font-sans">

        {{-- MAIN CARD CONTAINER --}}
        <div class="airmail-border max-w-5xl w-full transform -rotate-1 hover:rotate-0 transition-transform duration-700 ease-out">

            {{-- PAPER INNER --}}
            <div class="postcard-paper w-full h-full min-h-[550px] relative grid md:grid-cols-2 shadow-inner">

                {{-- VERTICAL DIVIDER (Only on Desktop) --}}
                <div class="hidden md:block absolute left-1/2 top-8 bottom-8 w-px bg-gray-300 opacity-50"></div>

                {{-- LEFT SIDE: MESSAGE --}}
                <div class="p-8 md:p-14 flex flex-col justify-center relative z-10">

                    <div class="font-handwriting text-2xl md:text-[1.6rem] text-blue-900 leading-loose">

                        @if($donation->is_gift)
                            {{-- === GIFT SCENARIO === --}}
                            <p class="mb-6 font-bold">Olá {{ $donation->gift_recipient_name }},</p>

                            <p class="mb-4 text-gray-800">
                                Tenho uma surpresa para ti!
                            </p>

                            <p class="mb-6">
                                O/A <span class="text-emerald-700 font-bold decoration-clone bg-emerald-50/80 px-1 rounded">{{ $donation->donor_name }}</span> decidiu oferecer-te um presente com significado, apoiando as crianças da Casa da Mamé.
                            </p>

                            @if($donation->gift_message)
                                <div class="mb-6 relative">
                                    <span class="text-4xl text-blue-200 absolute -top-4 -left-2">"</span>
                                    <p class="text-gray-600 italic px-4">
                                        {{ $donation->gift_message }}
                                    </p>
                                    <span class="text-4xl text-blue-200 absolute -bottom-8 right-0">"</span>
                                </div>
                            @endif

                            <div class="mt-8 pt-4">
                                <p class="text-lg text-gray-500 font-sans mb-1">Boas Festas,</p>
                                <p class="text-xl font-bold text-blue-800">Na Rota dos Povos</p>
                            </div>

                        @else
                            {{-- === PERSONAL RECEIPT SCENARIO === --}}
                            <p class="mb-6 font-bold">Caro(a) {{ $donation->donor_name }},</p>

                            <p class="mb-6">
                                A equipa da <strong>Na Rota dos Povos</strong> agradece, de coração, o teu gesto de imensa generosidade.
                            </p>

                            <p class="mb-6">
                                Este postal simboliza a esperança que ajudaste a semear na Guiné-Bissau.
                            </p>

                            <div class="mt-12 text-right">
                                <p class="text-lg text-gray-500 font-sans mb-1">Com gratidão,</p>
                                <p class="text-xl font-bold text-blue-800">A Direção</p>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- RIGHT SIDE: ADDRESS & STAMPS --}}
                <div class="p-8 md:p-12 flex flex-col relative z-10">

                    {{-- TOP AREA: HEADER & STAMP --}}
                    <div class="flex justify-between items-start mb-16">
                        <div class="pt-2 opacity-30">
                            <h1 class="font-sans font-bold text-gray-400 tracking-[0.5em] text-lg uppercase select-none">Post Card</h1>
                        </div>

                        <div class="flex items-center gap-6 relative">
                            {{-- Round Postmark --}}
                            <div class="hidden sm:flex flex-col items-center justify-center w-24 h-24 rounded-full postmark-ring rotate-[-12deg] absolute -left-20 top-4 mix-blend-multiply">
                                <span class="text-[10px] uppercase tracking-widest font-bold">Via Aérea</span>
                                <span class="text-sm font-bold mt-1">NATAL</span>
                                <span class="text-[10px]">{{ date('Y') }}</span>
                                <div class="w-16 h-px bg-gray-400/30 my-1"></div>
                                <span class="text-[9px]">Viana do Castelo</span>
                            </div>

                            {{-- The Stamp --}}
                            <div class="postage-stamp p-1.5 shadow-md rotate-2">
                                <div class="w-[85px] h-[100px] bg-emerald-50 flex flex-col items-center justify-center border border-dotted border-gray-300 relative overflow-hidden">
                                    <div class="absolute top-0 right-0 w-4 h-4 bg-emerald-800 transform rotate-45 translate-x-2 -translate-y-2"></div>
                                    <img src="/images/funding/christmas2025/tree.png" class="h-14 w-auto object-contain mb-2 drop-shadow-sm" alt="Christmas Tree">
                                    <span class="text-xs font-bold text-emerald-900 border-t border-emerald-200 pt-1 w-full text-center">
                                        {{ number_format($donation->amount, 0) }} €
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ADDRESS LINES --}}
                    <div class="mt-auto space-y-8 font-typewriter text-gray-800 text-xl pl-4 md:pl-8">

                        <div class="border-b border-gray-300 pb-1 relative">
                            <span class="text-[10px] text-gray-400 absolute -top-4 left-0 font-sans uppercase tracking-widest">Destinatário:</span>
                            ONGD NA ROTA DOS POVOS
                        </div>

                        <div class="border-b border-gray-300 pb-1">
                            Casa da Mamé
                        </div>

                        <div class="border-b border-gray-300 pb-1 flex justify-between items-baseline">
                            <span>Bissau / Portugal</span>
                            <span class="text-xs font-sans text-gray-400 uppercase tracking-widest">Prioritário</span>
                        </div>

                        {{-- Lucky Ticket / Donation Number --}}
                        <div class="pt-6 flex justify-end">
                            <div class="bg-yellow-100/80 text-yellow-800 text-xs font-mono px-3 py-1.5 rounded-sm shadow-sm border border-yellow-200 -rotate-2">
                                TICKET NO. <span class="font-bold text-base tracking-widest">#{{ $donation->access_code }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- BACK BUTTON --}}
        <div class="fixed bottom-8 right-8 print:hidden z-50">
            <a href="{{ route('christmas.board') }}"
               class="group bg-emerald-700 text-white px-6 py-3 rounded-full shadow-xl font-bold text-sm hover:bg-emerald-800 hover:-translate-y-1 transition-all flex items-center gap-3 border-2 border-white ring-2 ring-emerald-700/20">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar à Árvore
            </a>
        </div>
    </div>
</div>
