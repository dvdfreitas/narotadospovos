<x-guestLayout>
    <x-margins-text>
        @if (session('language') === 'pt')
            <h1>Como ajudar</h1>
        @elseif (session('language') === 'en')
            <h1>How to help</h1>
        @endif


            <p>Se der um pouco vai faltar menos.</p>
            <p>Neste processo de fazer do mundo um lugar melhor, todos contam.</p>
            <p>Junte-se a nós.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 rounded my-6">
                <a href="#firquidja" class="rounded bg-nrp-blue  px-2">
                    <div class="px-2 rounded text-center">
                        <p class="text-white mt-2 text-3xl  bg-nrp-green rounded px-2 py-1">Ser Firquidja</p>
                        <p class="mx-2 my-3 text-white">Apoie as nossas crianças tornando-se num firquidja da Casa da Mamé!</p>
                    </div>
                </a>

                <a href="#donativo" class="rounded bg-nrp-green px-2">
                    <div class="text-center">
                        <p class="text-white mt-2 text-3xl  bg-nrp-blue rounded px-2 py-1">Donativo</p>
                        <p class="mx-2 my-3 text-white">Faça um donativo e seja a mudança que quer ver no mundo!</p>
                    </div>
                </a>

                <div class="bg-nrp-blue px-2 rounded text-center">
                    <p class="text-white mt-2 text-3xl  bg-nrp-green rounded px-2 py-1">Voluntariado</p>
                    <p class="mx-2 my-3 text-white">Tem algumas horas livres que gostava de dedicar à "Na Rota dos Povos"?</p>
                </div>
            </div>

            <div class="my-8 mt-16" id="donativo"></div>

            <h2>Donativo</h2>
                <div class="mt-8">
                    <div class="gap-x-1">
                        <p class="my-auto">Pode fazer um donativo através do IBAN</p>
                        <div class="flex my-4">
                            <input type="text" disabled class="border-nrp-green  border-2 rounded" id="iban" value="PT50 0036 0407 99106015040 19">
                            <button onclick="myFunction('iban')" class="px-4 bg-nrp-green text-white rounded">Copiar</button>
                        </div>
                    </div>
                    <div id="clipiban" style="visibility: hidden" class="text-xs font-bold text-nrp-green">IBAN copiado para o Clipboard</div>
                </div>
                <div class="mt-8">
                    <div class="gap-x-1">
                        <p class="my-auto">Ou através de MB Way:</p>
                        <div class="flex my-4">
                            <input type="text" disabled class="w-32 text-center border-nrp-green  border-2 rounded" id="phone" value="932412050">
                            <button onclick="myFunction('phone')" class="px-4 bg-nrp-green text-white rounded">Copiar</button>
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
                <div class="space-y-4">
                    <a href="/help"><img class="rounded-xl" src="/images/campanhas/2024_campanha_essenciais.jpg" class="m-auto"></a>
                    <img src="images/help/give1.jpg" class="m-auto">
                    <img src="images/help/give2.jpg" class="m-auto">
                    <img src="images/help/give3.jpg" class="m-auto">
                    <img src="images/help/give4.jpg" class="m-auto">
                </div>


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
