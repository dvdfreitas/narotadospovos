<?php

use function Livewire\Volt\{layout, title, state};

layout('layouts.guest');
title('Política de Privacidade - Na Rota dos Povos');

state([
    'lastUpdated' => date('d/m/Y')
]);

?>

<div class="min-h-screen bg-slate-50 font-sans text-slate-600 antialiased selection:bg-emerald-200 selection:text-emerald-900">

    {{-- 1. HERO HEADER --}}
    <div class="bg-emerald-900 text-white pt-16 pb-32 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs><pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="2" cy="2" r="1" class="text-white" fill="currentColor" /></pattern></defs>
                <rect width="100%" height="100%" fill="url(#dots)" />
            </svg>
        </div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            {{-- Ícone do cabeçalho melhorado (sem círculo fantasma, apenas o ícone limpo) --}}
            <div class="mb-4 text-emerald-300 opacity-80">
                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight mb-4 drop-shadow-sm">
                Política de Privacidade
            </h1>
        </div>
    </div>

    {{-- 2. CONTEÚDO PRINCIPAL --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 pb-24 relative z-20">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">

            {{-- Toolbar --}}
            <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Documento Legal</span>
                <button onclick="window.print()" class="group flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-emerald-600 uppercase tracking-wider transition-colors">
                    <span class="hidden sm:inline">Guardar PDF</span>
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2-2v4h10z"></path></svg>
                </button>
            </div>

            {{-- CORPO --}}
            <div class="p-8 sm:p-14 space-y-16">

                {{-- SECÇÃO 1: RESPONSÁVEL --}}
                <section>
                    <div class="flex items-start gap-4">
                        {{-- BOLA CORRIGIDA: Mais pequena (w-8) e alinhada --}}
                        <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm mt-1">1</span>
                        
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-slate-900 mb-8">Responsável pelo Tratamento</h2>

                            <div class="bg-slate-50 rounded-2xl p-8 border border-slate-200 shadow-sm">
                                <div class="grid sm:grid-cols-2 gap-10">
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Entidade</p>
                                        <p class="font-bold text-slate-800 text-lg">ONGD Na Rota dos Povos</p>
                                        <p class="text-sm text-slate-500 mt-1">Associação Sem Fins Lucrativos</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Identificação Fiscal</p>
                                        <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm">
                                            <span class="font-mono font-bold text-slate-700 tracking-wide">NIPC: 510 878 989</span>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-2 pt-6 border-t border-slate-200 mt-2">
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Contacto Privacidade</p>
                                        <a href="mailto:ongd@narotadospovos.org" class="text-emerald-600 font-bold text-lg hover:text-emerald-800 hover:underline flex items-center gap-2 w-fit transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            ongd@narotadospovos.org
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100 my-8">

                {{-- SECÇÃO 2: DADOS RECOLHIDOS --}}
                <section>
                    <div class="flex items-start gap-4">
                         {{-- BOLA CORRIGIDA --}}
                        <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm mt-1">2</span>
                        
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-slate-900 mb-8">Dados Recolhidos</h2>
                            
                            <div class="grid sm:grid-cols-2 gap-8">
                                <div class="bg-white p-6 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300">
                                    <strong class="text-emerald-800 mb-4 flex items-center gap-2 text-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Dados do Doador
                                    </strong>
                                    <p class="text-sm leading-relaxed text-slate-600">Nome, Email, Telemóvel e NIF (opcional para recibo).</p>
                                </div>
                                <div class="bg-white p-6 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300">
                                    <strong class="text-emerald-800 mb-4 flex items-center gap-2 text-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Financeiros
                                    </strong>
                                    <p class="text-sm leading-relaxed text-slate-600">Valor, campanha, método e identificadores técnicos do pedido.</p>
                                </div>
                                <div class="bg-white p-6 rounded-2xl border border-slate-100 hover:border-emerald-200 hover:shadow-lg transition-all duration-300 sm:col-span-2">
                                    <strong class="text-emerald-800 mb-4 flex items-center gap-2 text-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                        Opcionais (Conteúdo)
                                    </strong>
                                    <p class="text-sm leading-relaxed text-slate-600">Mensagem pública para a árvore e dados de "Oferta" (Nome do destinatário e mensagem personalizada).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100 my-8">

                {{-- SECÇÃO 3: FINALIDADES --}}
                <section>
                    <div class="flex items-start gap-4">
                         {{-- BOLA CORRIGIDA --}}
                        <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-sm mt-1">3</span>
                        
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-slate-900 mb-10">Finalidades e Bases Legais</h2>

                            <div class="space-y-12">
                                {{-- Item 1 --}}
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="font-bold text-slate-800 text-lg">Processamento do Donativo</h3>
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-500 border border-slate-200">Contratual</span>
                                    </div>
                                    <p class="text-slate-600 leading-relaxed max-w-2xl">
                                        Para validar o pagamento e garantir que o apoio chega ao destino.
                                    </p>
                                </div>

                                {{-- Item 2 --}}
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="font-bold text-slate-800 text-lg">Obrigações Fiscais</h3>
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-slate-100 text-slate-500 border border-slate-200">Obrigação Legal</span>
                                    </div>
                                    <p class="text-slate-600 leading-relaxed max-w-2xl">
                                        Emissão de recibos e comunicação à Autoridade Tributária.
                                    </p>
                                </div>

                                {{-- Item 3 --}}
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="font-bold text-slate-800 text-lg">Postal Digital ("Oferta")</h3>
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-blue-50 text-blue-600 border border-blue-100">Consentimento</span>
                                    </div>
                                    <p class="text-slate-600 mb-4 leading-relaxed max-w-2xl">
                                        Para gerar o postal personalizado.
                                    </p>
                                    <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-100 inline-block max-w-2xl">
                                        <p class="text-sm text-slate-600">
                                            <strong class="text-emerald-700 block mb-1">Nota Importante:</strong>
                                            A ONGD não envia emails ao destinatário da oferta. O link é gerado para o doador, que o partilha por sua iniciativa.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-slate-100 my-8">

                {{-- SECÇÃO 4 & 5 --}}
                <div class="grid md:grid-cols-2 gap-12 lg:gap-20">
                    <section>
                        <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
                            Partilha de Dados
                        </h2>
                        <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                            Não vendemos os seus dados. Partilhamos apenas o estritamente necessário para o funcionamento do serviço com:
                        </p>
                        <ul class="space-y-4 text-sm">
                            <li class="flex items-center gap-3 text-slate-700 bg-white p-3 rounded-lg border border-slate-100 shadow-sm">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong>Ifthenpay</strong> (Pagamentos)</span>
                            </li>
                            <li class="flex items-center gap-3 text-slate-700 bg-white p-3 rounded-lg border border-slate-100 shadow-sm">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong>Autoridade Tributária</strong> (Lei)</span>
                            </li>
                            <li class="flex items-center gap-3 text-slate-700 bg-white p-3 rounded-lg border border-slate-100 shadow-sm">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span><strong>Fornecedores Técnicos</strong> (Servidores)</span>
                            </li>
                        </ul>
                    </section>

                    <section>
                        <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
                            Prazos de Conservação
                        </h2>
                        <div class="space-y-6">
                            <div class="flex gap-5 items-start">
                                <div class="text-right w-20 pt-1">
                                    <span class="block text-3xl font-black text-emerald-900 leading-none">10</span>
                                    <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Anos</span>
                                </div>
                                <div class="flex-1 text-sm text-slate-600 border-l-2 border-slate-100 pl-5 pt-1 leading-relaxed">
                                    Para dados fiscais e contabilísticos (faturas, recibos), conforme exigido por lei.
                                </div>
                            </div>
                            <div class="flex gap-5 items-start">
                                <div class="text-right w-20 pt-1">
                                    <span class="block text-3xl font-black text-emerald-900 leading-none">90</span>
                                    <span class="text-[10px] font-bold uppercase text-slate-400 tracking-wider">Dias</span>
                                </div>
                                <div class="flex-1 text-sm text-slate-600 border-l-2 border-slate-100 pl-5 pt-1 leading-relaxed">
                                    Para dados acessórios da campanha (mensagens públicas e postais) após o fim da mesma.
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- SECÇÃO 6: DIREITOS --}}
                <div class="bg-blue-50 rounded-2xl p-8 sm:p-10 text-center sm:text-left flex flex-col sm:flex-row items-center gap-8 border border-blue-100 mt-8">
                    <div class="bg-white p-4 rounded-full shadow-md text-blue-600 shrink-0">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-blue-900 mb-3">Os seus Direitos e Reclamações</h3>
                        <p class="text-base text-blue-900/80 leading-relaxed">
                            Pode exercer os seus direitos de acesso, retificação, apagamento ou oposição a qualquer momento via email.
                            Caso considere necessário, tem o direito de apresentar reclamação à <strong>CNPD</strong>.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- BOTÃO VOLTAR --}}
        <div class="my-16 text-center print:hidden">
            {{-- BOTÃO CORRIGIDO: Padding ajustado e w-fit para não apertar o texto --}}
            <a href="{{ route('christmas.board') }}"
               class="inline-flex items-center gap-3 px-8 py-3 rounded-full bg-emerald-600 text-white font-bold shadow-xl shadow-emerald-600/20 hover:bg-emerald-700 hover:-translate-y-1 transition-all text-base w-fit mx-auto">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar à Árvore de Natal
            </a>
        </div>

    </div>
</div>