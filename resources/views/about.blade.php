<x-guestLayout>

    <x-banner-image image="/images/banners/who_we_are.jpg" />


    <x-margins-text>
        @if (session('language') === 'pt')
            <p>A “Na Rota dos Povos” é uma Organização Não Governamental para o Desenvolvimento (ONGD), criada em 2001, com sede em Matosinhos, Portugal. Toda a nossa atividade é assegurada por voluntários. Atuamos, há mais de 10 anos, no Sul da Guiné-Bissau, sob o lema <b class="text-nrp-blue">“A Educação é o Único Caminho”</b>, com o objetivo de melhorar o desenvolvimento dos povos em zonas mais carenciadas, fora dos grandes centros populacionais.  </p>
            <p>A nossa <b class="text-nrp-blue">missão</b> é apoiar e desenvolver ações para a defesa, elevação e manutenção da qualidade de vida do ser humano e do meio ambiente, através do desenvolvimento de atividades de carácter educativo, social, cultural, ambiental e desportivo.</p>
            <p><b class="text-nrp-blue">Valorizamos</b> a cooperação, o diálogo intercultural e o apoio direto e efetivo a projetos de organizações congéneres nacionais ou internacionais, nomeadamente através da conceção, execução, facilitação e realização de programas em áreas privilegiadas como a educação, o apoio social e a saúde.</p>
        @elseif (session('language') === 'en')
            <p>“Na Rota dos Povos” is a Non-Governmental Organization for Development (NGDO), created in 2001, with headquarters in Matosinhos, Portugal. All our activity is ensured by volunteers. We have been operating for more than 10 years in southern Guinea-Bissau, under the motto <b class="text-nrp-blue">“Education is the Only Way”</b>, with the aim of improving the development of peoples in more deprived areas, outside the major population centers.</p>
            <p>Our <b class="text-nrp-blue">mission</b> is to support and develop actions for the defense, elevation, and maintenance of the quality of life of the human being and the environment, through the development of educational, social, cultural, environmental, and sports activities.</p>
            <p>We <b class="text-nrp-blue">value</b> cooperation, intercultural dialogue, and direct and effective support for projects of national or international peer organizations, namely through the conception, execution, facilitation, and realization of programs in privileged areas such as education, social support, and health.</p>
        @endif

        <div class="border-4 border-nrp-blue rounded-xl my-4 ">
            <div class="m-auto">
                <img src="/images/maps/guinebissau.png" class="w-2/3 m-auto my-8">
            </div>
            <div class=" mx-4 pl-6 my-4">
                @if (session('language') === 'pt')

                    <p>A Guiné-Bissau é um pequeno país da África ocidental constituído por uma parte continental e outra insular que engloba o arquipélago dos Bijagós. A sua superfície é de 36 125 km2 (cerca de 1/3 da área de Portugal) e tem aproximadamente 2 milhões de habitantes (cerca de 1/5 da população portuguesa). 55% dos habitantes são jovens até aos 19 anos (de acordo com dados do Instituto Nacional de Estatística da Guiné- Bissau de 2017). É, portanto, um país com extrema predominância de crianças e jovens, faixas etárias mais frágeis, mas, por outro lado, aquelas em que melhorias na educação e na saúde são mais promissoras.</p>
                    <p>O crioulo é considerado a língua nacional e é o meio de comunicação entre os diferentes grupos étnicos. O português, declarada língua oficial, é pouco falado e o seu uso limita-se aos meios oficiais e a um pequeno número de guineenses.</p>
                    <p>Cerca de metade da população adulta não sabe ler nem escrever.</p>
                    <p>Aproximadamente 66,6% da população vivia abaixo do limiar da pobreza em 2020 (ou seja, com menos de dois dólares norte-americanos por dia).</p>
                @elseif (session('language') === 'en')
                    <p>Guinea-Bissau is a small country in West Africa consisting of a continental part and an insular part that includes the Bijagós archipelago. Its surface area is 36,125 km2 (about 1/3 of the area of Portugal) and has approximately 2 million inhabitants (about 1/5 of the Portuguese population). 55% of the inhabitants are young people up to 19 years old (according to data from the National Institute of Statistics of Guinea-Bissau from 2017). It is, therefore, a country with an extreme predominance of children and young people, age groups that are more fragile, but, on the other hand, those in which improvements in education and health are more promising.</p>
                    <p>Kriol is considered the national language and is the means of communication between different ethnic groups. Portuguese, declared the official language, is little spoken and its use is limited to official circles and a small number of Guineans.</p>
                    <p>Approximately half of the adult population cannot read or write.</p>
                    <p>Approximately 66.6% of the population lived below the poverty line in 2020 (i.e., with less than two US dollars per day).</p>
                @endif
            </div>
        </div>
    </x-margins-text>
</x-guestLayout>
