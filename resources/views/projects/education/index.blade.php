<x-guestLayout>

    <x-banner-image image="/images/projects/education/education1.jpg" />

    <x-margins-text>

        @if (session('language') === 'pt')
            <h1>Projetos</h1>
        @elseif (session('language') === 'en')
            <h1>Projects</h1>
        @endif


        @if (session('language') === 'pt')
            <p>De acordo com dados da <a class="text-nrp-blue" href="https://data.unicef.org/wp-content/uploads/2021/12/Guinea-Bissau-Education-Fact-Sheet-2018.pdf">UNICEF</a>, de 2021, estima-se que 160 mil crianças estejam fora da escola na Guiné-Bissau, metade das quais deveriam estar a frequentar o ensino básico. Aproximadamente 85% das crianças na Guiné-Bissau não têm um livro em casa.</p>
            <p>As taxas de conclusão diminuem a cada nível educativo na Guiné-Bissau. Em média 27% das crianças concluem os primeiros ciclos do ensino básico (1º e 2º), 17 % o 3º ciclo e apenas 11% o nível secundário. Para além das baixas taxas de conclusão, há fortes desigualdades no país, sobretudo ligadas ao nível de riqueza dos agregados familiares, local de residência, género e etnia das crianças. Aliado a graves problemas como o trabalho infantil e o casamento precoce, as condições e acesso às escolas são muito precários. Faltam professores, livros, manuais escolares, salas de aula, carteiras, cadeiras. As paredes das salas são em blocos de terra escura secos ao sol e os telhados de zinco ou palha. A fragilidade deste tipo de construção não permite ter janelas com dimensões razoáveis, havendo muito pouca luminosidade. As paredes são muito vulneráveis à chuva, e é difícil manter as salas com aspeto limpo.</p>
            <p>A “Na Rota dos Povos” trabalha em parceria com algumas escolas portuguesas, seguindo sempre o lema de que “A Educação é o Único Caminho”.</p>
            <p>Equipámos 220 salas de aulas em 50 escolas na região de Tombali e fornecemos, anualmente, material escolar aos 10 000 alunos apoiados anualmente. Montámos 5 bibliotecas fixas (duas em Catió, uma das quais infantil; Quebo, Bedanda e Cacine). Criámos também um conceito desconhecido em Tombali, uma biblioteca itinerante, que consiste numa moto que transporta livros pelas diferentes aldeias.</p>
            <p>Criámos 2 sala de informática com cerca de 30 computadores cada sala, e contribuímos para a formação de professores.</p>
        @elseif (session('language') === 'en')
            <p>According to <a class="text-nrp-blue" href="https://data.unicef.org/wp-content/uploads/2021/12/Guinea-Bissau-Education-Fact-Sheet-2018.pdf">UNICEF</a> data from 2021, it is estimated that 160,000 children are out of school in Guinea-Bissau, half of whom should be attending basic education. Approximately 85% of children in Guinea-Bissau do not have a book at home.</p>
            <p>Completion rates decrease at each educational level in Guinea-Bissau. On average, 27% of children complete the first cycles of basic education (1st and 2nd), 17% the 3rd cycle, and only 11% the secondary level. In addition to low completion rates, there are strong inequalities in the country, mainly related to the wealth level of households, place of residence, gender and ethnicity of children. In addition to serious problems such as child labor and early marriage, the conditions and access to schools are very precarious. There is a lack of teachers, books, textbooks, classrooms, desks, chairs. The walls of the rooms are made of blocks of dark earth dried in the sun and the roofs of zinc or straw. The fragility of this type of construction does not allow for windows of reasonable dimensions, there is very little light. The walls are very vulnerable to rain, and it is difficult to keep the rooms looking clean.</p>
            <p>“Na Rota dos Povos” works in partnership with some Portuguese schools, always following the motto that “Education is the Only Way”.</p>
            <p>We equipped 220 classrooms in 50 schools in the Tombali region and annually provide school supplies to the 10,000 students supported annually. We set up 5 fixed libraries (two in Catió, one of which is children's; Quebo, Bedanda, and Cacine). We also created an unknown concept in Tombali, a traveling library, which consists of a motorcycle that transports books through different villages.</p>
        @endif
    </x-margins-text>
</x-guestLayout>
