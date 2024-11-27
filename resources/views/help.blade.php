<x-guestLayout>
    <x-margins-text>
        @if (session('language') === 'pt')
            <h1>Como ajudar</h1>
        @elseif (session('language') === 'en')
            <h1>How to help</h1>
        @endif

        @if (session('language') === 'pt')
            <p>Se der um pouco vai faltar menos.</p>
            <p>Neste processo de fazer do mundo um lugar melhor, todos contam.</p>
            <p>Junte-se a nós.</p>
        @elseif (session('language') === 'en')
            <p>If you give a little, there will be less missing.</p>
            <p>In this process of making the world a better place, everyone counts.</p>
            <p>Join us.</p>
        @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 rounded my-6">
                <a href="#firquidja" class="rounded bg-nrp-blue  px-2">
                    <div class="px-2 rounded text-center">
                        @if (session('language') === 'pt')
                            <p class="text-white mt-2 text-3xl  bg-nrp-green rounded px-2 py-1">Ser Firquidja</p>
                            <p class="mx-2 my-3 text-white">Apoie as nossas crianças tornando-se num firquidja da Casa da Mamé!</p>
                        @elseif (session('language') === 'en')
                            <p class="text-white mt-2 text-3xl  bg-nrp-green rounded px-2 py-1">Be a Firquidja</p>
                            <p class="mx-2 my-3 text-white">Support our children by becoming a firquidja of Casa da Mamé!</p>
                        @endif
                    </div>
                </a>

                <a href="#donativo" class="rounded bg-nrp-green px-2">
                    <div class="text-center">
                        @if (session('language') === 'pt')
                            <p class="text-white mt-2 text-3xl  bg-nrp-blue rounded px-2 py-1">Donativo</p>
                            <p class="mx-2 my-3 text-white">Faça um donativo e seja a mudança que quer ver no mundo!</p>
                        @elseif (session('language') === 'en')
                            <p class="text-white mt-2 text-3xl  bg-nrp-blue rounded px-2 py-1">Donation</p>
                            <p class="mx-2 my-3 text-white">Make a donation and be the change you want to see in the world!</p>
                        @endif
                    </div>
                </a>

                <div class="bg-nrp-blue px-2 rounded text-center">
                    @if (session('language') === 'pt')
                        <p class="text-white mt-2 text-3xl  bg-nrp-green rounded px-2 py-1">Voluntariado</p>
                        <p class="mx-2 my-3 text-white">Tem algumas horas livres que gostava de dedicar à "Na Rota dos Povos"?</p>
                    @elseif (session('language') === 'en')
                        <p class="text-white mt-2 text-3xl  bg-nrp-green rounded px-2 py-1">Volunteering</p>
                        <p class="mx-2 my-3 text-white">Do you have some free hours that you would like to dedicate to "Na Rota dos Povos"?</p>
                    @endif
                </div>
            </div>

            <div class="my-8 mt-16" id="donativo"></div>

            @if (session('language') === 'pt')
                <h2>Donativos</h2>
            @elseif (session('language') === 'en')
                <h2>Donations</h2>
            @endif

                <div class="mt-8">
                    <div class="gap-x-1">
                        @if (session('language') === 'pt')
                            <p class="my-auto">Pode fazer um donativo através do IBAN</p>
                        @elseif (session('language') === 'en')
                            <p class="my-auto">You can make a donation through IBAN</p>
                        @endif
                        <div class="flex my-4">
                            <input type="text" disabled class="border-nrp-green  border-2 rounded w-72" id="iban" value="PT50 0036 0407 99106015040 19">
                            <button onclick="myFunction('iban')" class="px-4 bg-nrp-green text-white rounded">
                                @if (session('language') === 'pt')
                                    Copiar
                                @elseif (session('language') === 'en')
                                    Copy
                                @endif
                            </button>
                        </div>
                    </div>
                    <div id="clipiban" style="visibility: hidden" class="text-xs font-bold text-nrp-green">IBAN copiado para o Clipboard</div>
                </div>
                <div class="mt-8">
                    <div class="gap-x-1">
                        @if (session('language') === 'pt')
                            <p class="my-auto">Ou através de MB Way:</p>
                        @elseif (session('language') === 'en')
                            <p class="my-auto">Or through MB Way:</p>
                        @endif
                        <div class="flex my-4">
                            <input type="text" disabled class="w-32 text-center border-nrp-green  border-2 rounded" id="phone" value="932412050">
                            <button onclick="myFunction('phone')" class="px-4 bg-nrp-green text-white rounded">
                                @if (session('language') === 'pt')
                                    Copiar
                                @elseif (session('language') === 'en')
                                    Copy
                                @endif
                            </button>
                        </div>
                    </div>
                    <div id="clipphone" style="visibility: hidden" class="text-xs font-bold text-nrp-green">Número copiado para o Clipboard</div>
                </div>

                <ol class="list-decimal mt-8">
                    <li>Leia o QR Code com a app MB WAY através de "Pagar com MB WAY"</li>
                    <li>Insira o montante a doar</li>
                    <li>Confirme a operação</li>
                    <img src="/images/help/solidario.png" class="my-8"/>
                </ol>

                <div class="h-12"></div>
                <hr>
                <div class="h-12"></div>

                <p class="my-8">Poderá também, em alternativa, seguir os seguintes passos:</p>
                <ol>
                    <li><div class="flex space-x-2"><p class="text-nrp-blue font-bold">Passo 1: </p><p>Abrir o MB Way</li>
                    <li>
                        <div class="flex space-x-2"><p class="text-nrp-blue font-bold">Passo 2: </p><p>Clicar no ícone "Ser Solidário"</p></div>
                        <p><img class="w-16 ml-24 my-4" src="/images/help/solidario_icon.png"/></p>
                    </li>
                    <li>
                        <div class="flex space-x-2"><p class="text-nrp-blue font-bold">Passo 3: </p><p>Escolher "Associação Na Rota dos Povos"</p></div>
                    </li>
                    <li>
                        <div class="flex space-x-2"><p class="text-nrp-blue font-bold">Passo 4: </p><p>Escolher o valor a doar</p></div>
                    </li>
                    <li>
                        <div class="flex space-x-2"><p class="text-nrp-blue font-bold">Passo 5: </p><p>Confirmar a operação</p></div>
                    </li>
                </ol>


            <div class="my-8 mt-16"></div>

            <h2>Bens essenciais</h2>


            <p></p>


            <div class="my-8 mt-16" id="firquidja"></div>

            <h2>Ser Firquidja</h2>
                <div>
                    <div class="flex-wrap flex gap-x-1">
                        <p>Somos a ONGD Na Rota dos Povos. Acreditamos que “A Educação é o Único Caminho” e estamos desde 2010 em
                        Catió, sul da Guiné-Bissau, a ajudar o seu povo a trilhar o seu caminho. Apoiamos a comunidade, com participação
                        ativa na identificação de problemas e na sua resolução. As áreas principais de intervenção são a educação, a saúde
                        e o apoio e proteção social às crianças. Um dos maiores projetos, a Casa da Mamé, em Catió, acolhe 20 crianças e
                        bebés órfãos cujas mães faleceram no parto ou pós-parto.
                        Sentimo-nos parte da família Guineense. Em crioulo, diz-se que um membro da família que garante que tudo corre
                        bem é um Firquidja. Faça parte desta família, seja nosso Firquidja, doando um valor regular fixo, por débito em
                        conta. Contribua para os cuidados, a alimentação, a saúde e a educação das nossas e suas crianças de Catió.</p>
                        <a href="/docs/firquidjas/firquidja_a5.pdf" class="my-16">
                            <img class="h-48 border-2 rounded border-solid" src="/docs/firquidjas/firquidja_a5.png" class="m-auto">
                        </a>
                    </div>
                </div>


            <h2>Pontos de Recolha</h2>
            <div class="my-2">
                <div>
                    <p class="font-bold">Armazém: </p>
                    <p>Rua Gonçalves Zarco, 2644</p>
                    <p>Santa Cruz do Bispo (próximo do Ikea Matosinhos)</p>
                    <p>Tel: 932 412 050</p>
                </div>
                <div>
                    <p class="font-bold">Curtes: <p>
                    <p>Rua da Portelinha, nº 483<p>
                    <p>4510-638 Fânzeres – Gondomar</p>
                </div>
            </div>
    </x-margins-text>


        <script>
            function myFunction(myInput) {
                // Get the text field
                var copyText = document.getElementById(myInput);

                // Select the text field
                copyText.select();
                copyText.setSelectionRange(0, 99999); // For mobile devices

                copyText.style.backgroundColor = "#DDEEDD";

                // Copy the text inside the text field to the clipboard of the navigator
                navigator.clipboard.writeText(copyText.value);

                document.getElementById("clip" + myInput).style.visibility = "visible";
            }

        </script>

</x-guestLayout>
