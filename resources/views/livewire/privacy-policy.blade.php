<?php

use function Livewire\Volt\{layout, title, state};

layout('layouts.guest');
title('Política de Privacidade - Na Rota dos Povos');

state([
    'lastUpdated' => '23 de Outubro de 2026',
]);

?>

{{--
    Escrita para quem contribui, não para juristas: frases curtas, só o que o
    RGPD obriga a dizer (art. 13.º) e o que é verdade hoje no site. Uma
    campanha que volte a recolher mensagens ou dedicatórias acrescenta aqui
    esses dados, a finalidade e o prazo.
--}}
<div class="min-h-screen bg-white font-sans text-slate-600 antialiased selection:bg-emerald-200 selection:text-emerald-900">

    {{-- 1. CABEÇALHO --}}
    <div class="bg-emerald-900 text-white pt-16 pb-32 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs><pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="1" class="text-white" fill="currentColor" /></pattern></defs>
                <rect width="100%" height="100%" fill="url(#dots)" />
            </svg>
        </div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <div class="mb-4 text-emerald-300 opacity-80">
                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>

            <h1 class="mt-0 text-3xl sm:text-5xl font-extrabold tracking-tight mb-4 drop-shadow-sm">
                Política de Privacidade
            </h1>

            <p class="text-emerald-100/90 text-lg max-w-2xl mx-auto leading-relaxed">
                Como a Na Rota dos Povos trata os dados de quem contribui,
                directamente ou através do Bazar Solidário.
            </p>
        </div>
    </div>

    {{-- 2. CONTEÚDO --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 pb-24 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">

            {{-- Barra --}}
            <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                    Última actualização: {{ $lastUpdated }}
                </span>
                <button type="button" onclick="window.print()" class="group flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-emerald-600 uppercase tracking-wider transition-colors print:hidden">
                    <span class="hidden sm:inline">Guardar PDF</span>
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                </button>
            </div>

            <div class="p-8 sm:p-14 space-y-14">

                {{-- 1. QUEM TRATA --}}
                <section class="flex items-start gap-4">
                    <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm mt-1">1</span>
                    <div class="flex-1">
                        <h2 class="mt-0 text-2xl font-bold text-slate-900 mb-6">Quem trata os seus dados</h2>

                        <div class="bg-slate-50 rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                            <div class="grid sm:grid-cols-2 gap-8">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Entidade</p>
                                    <p class="font-bold text-slate-800 text-lg">ONGD Na Rota dos Povos</p>
                                    <p class="text-sm text-slate-500 mt-1">Associação sem fins lucrativos</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Identificação fiscal</p>
                                    <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm">
                                        <span class="font-mono font-bold text-slate-700 tracking-wide">NIPC 510 878 989</span>
                                    </div>
                                </div>
                                <div class="sm:col-span-2 pt-6 border-t border-slate-200">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Questões sobre os seus dados</p>
                                    <a href="mailto:ongd@narotadospovos.org" class="text-emerald-600 font-bold text-lg hover:text-emerald-800 hover:underline flex items-center gap-2 w-fit transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        ongd@narotadospovos.org
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                {{-- 2. DADOS --}}
                <section class="flex items-start gap-4">
                    <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm mt-1">2</span>
                    <div class="flex-1">
                        <h2 class="mt-0 text-2xl font-bold text-slate-900 mb-6">Que dados recolhemos</h2>

                        <div class="grid sm:grid-cols-3 gap-5">
                            <div class="bg-white p-6 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300">
                                <strong class="text-emerald-800 mb-3 flex items-center gap-2 text-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Identificação
                                </strong>
                                <p class="my-0 text-sm leading-relaxed text-slate-600">Nome, email e telemóvel. O telemóvel é o número do MB Way, necessário para o pagamento.</p>
                            </div>
                            <div class="bg-white p-6 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300">
                                <strong class="text-emerald-800 mb-3 flex items-center gap-2 text-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Pagamento
                                </strong>
                                <p class="my-0 text-sm leading-relaxed text-slate-600">Valor, referência e a resposta do prestador de pagamentos. Não guardamos dados bancários.</p>
                            </div>
                            <div class="bg-white p-6 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300">
                                <strong class="text-emerald-800 mb-3 flex items-center gap-2 text-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Recibo
                                </strong>
                                <p class="my-0 text-sm leading-relaxed text-slate-600">NIF, morada, código postal e localidade, se os indicar. São opcionais.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                {{-- 3. PARA QUE --}}
                <section class="flex items-start gap-4">
                    <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm mt-1">3</span>
                    <div class="flex-1">
                        <h2 class="mt-0 text-2xl font-bold text-slate-900 mb-6">Para que os usamos</h2>

                        <div class="space-y-6">
                            <div>
                                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                    <h3 class="mt-0 font-bold text-slate-800 text-lg">O seu contributo</h3>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-500 border border-slate-200">Porque o pediu</span>
                                </div>
                                <p class="my-0 text-base text-slate-600 leading-relaxed">Processar o pagamento e enviar-lhe a confirmação por email.</p>
                            </div>
                            <div>
                                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                    <h3 class="mt-0 font-bold text-slate-800 text-lg">Obrigações fiscais</h3>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-500 border border-slate-200">Porque a lei o exige</span>
                                </div>
                                <p class="my-0 text-base text-slate-600 leading-relaxed">Emitir recibos e comunicar à Autoridade Tributária.</p>
                            </div>
                        </div>

                        <p class="mt-6 mb-0 text-base font-semibold text-slate-800">Não usamos os seus dados para mais nada.</p>
                    </div>
                </section>

                <hr class="border-slate-100">

                {{-- 4. PÚBLICO --}}
                <section class="flex items-start gap-4">
                    <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm mt-1">4</span>
                    <div class="flex-1">
                        <h2 class="mt-0 text-2xl font-bold text-slate-900 mb-6">O que fica público</h2>

                        <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 flex gap-4">
                            <svg class="w-6 h-6 shrink-0 text-emerald-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <div class="space-y-2">
                                <p class="my-0 text-base text-slate-700 leading-relaxed">
                                    No Bazar Solidário, cada contributo pago aparece na lista de contributos da página do Bazar,
                                    com o primeiro e o último nome, o que escolheu, o valor e a data.
                                </p>
                                <p class="my-0 text-sm text-slate-600 leading-relaxed">
                                    Se preferir, pode escolher aparecer como «Anónimo». O email, o telemóvel, o NIF e a morada nunca são mostrados.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100">

                {{-- 5 E 6 --}}
                <div class="grid md:grid-cols-2 gap-12 lg:gap-16">
                    <section>
                        <h2 class="mt-0 text-xl font-bold text-slate-900 mb-5 flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
                            Com quem partilhamos
                        </h2>
                        <p class="text-sm text-slate-600 mb-5 leading-relaxed">
                            Não vendemos os seus dados. Partilhamos apenas o necessário com:
                        </p>
                        <ul class="space-y-3 text-sm">
                            @foreach ([
                                ['ifthenpay', 'pagamentos MB Way'],
                                ['Autoridade Tributária', 'quando a lei o exige'],
                                ['Fornecedores técnicos', 'alojamento do site e envio de email'],
                            ] as [$who, $why])
                                <li class="flex items-center gap-3 text-slate-700 bg-white p-3 rounded-lg border border-slate-100 shadow-sm">
                                    <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span><strong>{{ $who }}</strong> — {{ $why }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </section>

                    <section>
                        <h2 class="mt-0 text-xl font-bold text-slate-900 mb-5 flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
                            Quanto tempo guardamos
                        </h2>
                        <div class="flex gap-5 items-start">
                            <div class="text-right w-16 pt-1">
                                <span class="block text-4xl font-black text-emerald-900 leading-none">10</span>
                                <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">anos</span>
                            </div>
                            <p class="my-0 flex-1 text-sm text-slate-600 border-l-2 border-slate-100 pl-5 pt-1 leading-relaxed">
                                Os dados dos contributos e dos recibos são guardados durante 10 anos, o prazo que a lei fiscal exige.
                            </p>
                        </div>
                    </section>
                </div>

                {{-- 7. DIREITOS --}}
                <div class="bg-blue-50 rounded-2xl p-8 sm:p-10 text-center sm:text-left flex flex-col sm:flex-row items-center gap-8 border border-blue-100">
                    <div class="bg-white p-4 rounded-full shadow-md text-blue-600 shrink-0">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h2 class="mt-0 text-xl font-bold text-blue-900 mb-3">Os seus direitos</h2>
                        <p class="my-0 text-base text-blue-900/80 leading-relaxed">
                            Pode pedir acesso aos seus dados, corrigi-los, apagá-los ou opor-se ao seu tratamento, escrevendo para
                            <a href="mailto:ongd@narotadospovos.org" class="font-semibold text-blue-900 underline underline-offset-4">ongd@narotadospovos.org</a>.
                            Os dados que a lei nos obriga a guardar só são apagados no fim desse prazo.
                            Pode também apresentar reclamação à
                            <a href="https://www.cnpd.pt" target="_blank" rel="noopener" class="font-semibold text-blue-900 underline underline-offset-4">Comissão Nacional de Protecção de Dados</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- VOLTAR --}}
        <div class="my-16 text-center print:hidden">
            <a href="{{ route('welcome') }}"
               class="inline-flex items-center gap-3 px-8 py-3 rounded-full bg-emerald-600 text-white font-bold shadow-xl shadow-emerald-600/20 hover:bg-emerald-700 hover:-translate-y-1 transition-all text-base w-fit mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar ao site
            </a>
        </div>
    </div>
</div>
