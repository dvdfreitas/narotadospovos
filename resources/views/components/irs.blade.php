<div>
    <img class="h-[600px] object-cover m-auto" src="/images/irs/2025-IRS-1.png"/>

    <x-margins-text>

        <p>A <span class="text-nrp-blue">consignação do IRS</span> permite que uma parte do seu imposto a favor do Estado seja encaminhada para uma entidade à sua escolha. Este gesto solidário não tem qualquer custo para si, nem implica a perda de benefícios fiscais, mas pode fazer toda a diferença para quem mais precisa.</p>
        <p>A Na Rota dos Povos é uma ONGD cuja missão é promover a educação, a proteção social e a saúde na região de Tombali, no sul da Guiné-Bissau. Sob o lema "A Educação é o Único Caminho", trabalhamos para transformar vidas: apoiamos cerca de 50 escolas com material e equipamento escolar, acolhemos na Casa da Mamé crianças que perderam a mãe no parto e proporcionamos apoio especializado a crianças com deficiência no Centro de Educação Especial e Terapêutica.</p>
        <p>A consignação do IRS é uma das principais fontes de financiamento da Na Rota dos Povos. Cada consignação é mais um passo que podemos dar. Um passo que damos juntos e que nos leva um pouco mais longe.</p>
        <p>Os próximos tempos serão desafiantes para nós com a construção da nova "Casa da Mamé". Cada consignação do IRS é um tijolo nesta nova casa. Cada partilha ergue paredes de conforto, desvenda janelas de esperança e abre portas para um futuro melhor.</p>
        <p>Faça da sua consignação um alicerce para este sonho.</p>
        <p>Muito obrigado.</p>
        <div class="flex my-4 content-center">
            <input type="text" disabled class="border-nrp-green  border-2 rounded w-72" id="nif" value="510878989">
            <button onclick="myFunction('nif')" class="px-4 bg-nrp-green text-white rounded">
                @if (session('language') === 'pt')
                    Copiar
                @elseif (session('language') === 'en')
                    Copy
                @endif
            </button>
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
</div>
