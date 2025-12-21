<?php

use function Livewire\Volt\{layout, title};

// Use the guest layout
layout('layouts.guest');
// Set page title
title('Política de Privacidade - Na Rota dos Povos');

?>

<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8 font-sans text-gray-700">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">

        <h1 class="text-3xl font-bold text-blue-900 mb-6 border-b pb-4">Política de Privacidade e Tratamento de Dados</h1>

        <div class="space-y-6 text-sm leading-relaxed">

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-2">1. Responsável pelo Tratamento</h2>
                <p>
                    Os dados recolhidos nesta campanha são tratados pela <strong>ONGD Na Rota dos Povos</strong>.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-2">2. Finalidade dos Dados</h2>
                <ul class="list-disc ml-5 space-y-1">
                    <li><strong>Processamento do Donativo:</strong> Para validar o pagamento e emitir o respetivo comprovativo.</li>
                    <li><strong>Obrigações Fiscais:</strong> O Nome e NIF são estritamente necessários para a emissão do recibo de donativo e comunicação à Autoridade Tributária (AT).</li>
                    <li><strong>Personalização do Postal:</strong> Os dados inseridos para efeitos de "Oferta" (nome do destinatário e mensagem) servem exclusivamente para a geração do postal digital.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-2">3. Conservação dos Dados</h2>
                <p>
                    Os dados fiscais (Nome, NIF, Valor) serão conservados pelo período legal obrigatório de <strong>10 anos</strong>.
                    Os dados acessórios (mensagens personalizadas e nomes de terceiros nos postais) poderão ser eliminados após o término da campanha.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-2">4. Partilha de Dados</h2>
                <p>
                    A Na Rota dos Povos <strong>não partilha</strong> os seus dados com terceiros para fins de marketing. Os dados são apenas comunicados às entidades competentes (AT) para cumprimento das obrigações legais.
                </p>
            </section>

            <section>
                <h2 class="text-xl font-bold text-gray-900 mb-2">5. Contacto</h2>
                <p>
                    Para exercer os seus direitos de acesso, retificação ou esquecimento, contacte-nos através do email:
                    <a href="mailto:geral@narotadospovos.org" class="text-emerald-600 underline">geral@narotadospovos.org</a>.
                </p>
            </section>

        </div>

        <div class="mt-8 pt-6 border-t flex justify-center">
            <a href="{{ route('christmas.board') }}" class="text-emerald-700 hover:text-emerald-900 font-medium">
                &larr; Voltar à Campanha de Natal
            </a>
        </div>
    </div>
</div>
