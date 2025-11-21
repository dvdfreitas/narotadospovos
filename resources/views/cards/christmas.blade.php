<x-guest-layout>

    {{-- 1. CARREGAR FONTES --}}
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Kalam:wght@300;400;700&display=swap" rel="stylesheet">

    {{-- 2. CSS ESSENCIAL --}}
    <style>
        .font-typewriter { font-family: 'Courier Prime', monospace; }
        .font-handwriting { font-family: 'Kalam', cursive; }

        /* Borda Airmail */
        .airmail-border {
            background-color: #fff;
            background-image: repeating-linear-gradient(
                135deg,
                #ef4444 0px, #ef4444 20px,
                #ffffff 20px, #ffffff 35px,
                #0369a1 35px, #0369a1 55px,
                #ffffff 55px, #ffffff 70px
            );
            padding: 15px;
        }

        /* Papel */
        .postcard-paper {
            background-color: #fdfbf7;
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 20px 20px;
        }

        /* Carimbo */
        .postmark-ring {
            border: 2px solid rgba(163, 163, 163, 0.5);
            color: rgba(163, 163, 163, 0.8);
        }
    </style>

    <div class="min-h-[calc(100vh-160px)] py-12 flex items-center justify-center bg-gray-100 px-4">

        {{-- CONTAINER EXTERNO --}}
        <div class="airmail-border shadow-2xl max-w-4xl w-full transform rotate-1 hover:rotate-0 transition-transform duration-500">

            {{-- O PAPEL DO POSTAL --}}
            <div class="postcard-paper w-full h-full min-h-[500px] relative grid md:grid-cols-2">

                {{-- RISCO VERTICAL DO MEIO --}}
                <div class="hidden md:block absolute left-1/2 top-4 bottom-4 w-px bg-gray-300"></div>

                {{-- ========================================== --}}
                {{-- LADO ESQUERDO: MENSAGEM PERSONALIZADA --}}
                {{-- ========================================== --}}
                <div class="p-8 md:p-12 flex flex-col justify-center relative z-10">
                    <div class="font-handwriting text-2xl md:text-2xl text-blue-900 leading-relaxed -rotate-1">

                        @if($donation->is_gift)
                            {{-- === CENÁRIO: PRENDA === --}}
                            <p class="mb-4 font-bold">Olá {{ $donation->gift_recipient_name }},</p>

                            <p class="mb-4 text-gray-700">
                                Temos uma novidade especial para ti!
                            </p>

                            <p class="mb-4">
                                O/A <strong class="text-emerald-700 bg-emerald-50 px-1">{{ $donation->donor_name }}</strong> decidiu oferecer-te um presente diferente este ano, fazendo um donativo em teu nome para a Casa da Mamé.
                            </p>

                            @if($donation->gift_message)
                                <p class="mb-4">
                                <strong class=" px-1">
                                        Deixou-te ainda a seguinte mensagem:
                                </strong>
                                </p>
                            <div class="mb-4 text-base text-gray-500 italic border-l-2 border-blue-200 pl-3">
                                    "{{ $donation->gift_message }}"
                                </div>
                            @endif

                            <div class="mt-8 text-right">
                                <p class="text-lg text-gray-500 font-sans">Um Santo Natal,</p>
                                <p class="text-xl font-bold text-blue-800">Na Rota dos Povos</p>
                            </div>

                        @else
                            {{-- === CENÁRIO: AGRADECIMENTO PESSOAL === --}}
                            <p class="mb-4 font-bold">Caro(a) {{ $donation->donor_name }},</p>

                            <p class="mb-4">
                                A equipa da <strong>Na Rota dos Povos</strong> agradece, de coração, o teu gesto de generosidade.
                            </p>

                            <p>
                                O teu contributo ajuda-nos a levar esperança e sorrisos às crianças da Casa da Mamé.
                            </p>

                            <div class="mt-10 text-right">
                                <p class="text-lg text-gray-500 font-sans">Com gratidão,</p>
                                <p class="text-xl font-bold text-blue-800">A Direção</p>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- LADO DIREITO: ENDEREÇO E SELO --}}
                {{-- ========================================== --}}
                <div class="p-8 md:p-12 flex flex-col relative z-10">

                    {{-- TOPO: Título + Selo --}}
                    <div class="flex justify-between items-start mb-12">
                        <div class="pt-4">
                            <h1 class="font-sans font-bold text-gray-300 tracking-[0.3em] text-xl uppercase">Postcard</h1>
                        </div>

                        <div class="flex items-center gap-4">
                            {{-- Carimbo --}}
                            <div class="hidden sm:flex flex-col items-center justify-center w-20 h-20 rounded-full postmark-ring rotate-[-12deg]">
                                <span class="text-[10px] uppercase tracking-widest">Solidário</span>
                                <span class="text-sm font-bold">NATAL</span>
                                <span class="text-[10px]">{{ date('Y') }}</span>
                            </div>

                            {{-- Selo --}}
                            <div class="bg-white p-1 shadow-sm border border-gray-200">
                                <div class="w-20 h-24 bg-emerald-50 flex flex-col items-center justify-center border border-dotted border-gray-300">
                                    <img src="/images/tree.png" class="h-14 w-auto object-contain mb-1">
                                    <span class="text-[10px] font-bold text-emerald-800">{{ number_format($donation->amount, 0) }} €</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ENDEREÇO --}}
                    <div class="mt-auto space-y-8 font-typewriter text-gray-800 text-lg">
                        <div class="border-b border-gray-300 pb-2 pl-2 relative">
                            <span class="text-xs text-gray-400 absolute -top-5 left-0 font-sans uppercase tracking-wider">Para:</span>
                            ONGD NA ROTA DOS POVOS
                        </div>
                        <div class="border-b border-gray-300 pb-2 pl-2">
                            Casa da Mamé
                        </div>
                        <div class="border-b border-gray-300 pb-2 pl-2">
                            Bissau / Portugal
                        </div>
                        <div class="pt-2 text-right">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded shadow-sm border border-yellow-200">
                                Donativo #{{ $donation->access_code }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- BOTÃO VOLTAR --}}
        <div class="fixed bottom-6 right-6 print:hidden z-50">
            <a href="{{ route('christmas-board') }}" class="bg-emerald-700 text-white px-5 py-3 rounded-full shadow-lg font-bold text-sm hover:bg-emerald-800 transition-all flex items-center gap-2 border-2 border-white">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar à Árvore
            </a>
        </div>

    </div>
</x-guest-layout>
