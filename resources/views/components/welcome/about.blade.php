<x-margins-text>
    @if (session('language') === 'pt')
        <div>
            <h1>Quem somos</h1>
            <p>A “Na Rota dos Povos” é uma Organização não Governamental para o Desenvolvimento (ONGD) com foco de atuação na educação, solidariedade social e saúde na região de Tombali, na Guiné-Bissau.</p>
            <p>A sede da ONGD é em Matosinhos e, todas as tarefas, tais como angariações, gestão de recursos, comunicação, e organização de missões, são realizadas por voluntários.</p>
            <p>Temos sede de delegação local na cidade de Catió, a cerca de 300 km da capital Bissau, onde damos emprego a 35 habitantes que colaboram nos diferentes projetos. A integração da ONGD na comunidade Cationense gera também uma onda de participação num país em que a solidariedade é característica deste povo sempre pronto a ajudar o vizinho.</p>
        </div>
    @elseif (session('language') === 'en')
        <div>
            <h1>Who we are</h1>
            <p>“Na Rota dos Povos” is a non-governmental organization for development (NGDO) focused on education, social solidarity, and health in the Tombali region of Guinea-Bissau.</p>
            <p>The headquarters of the NGDO is in Matosinhos and all tasks, such as fundraising, resource management, communication, and mission organization, are carried out by volunteers.</p>
            <p>We have a local delegation headquarters in the city of Catió, about 300 km from the capital Bissau, where we employ 35 residents who collaborate on different projects. The integration of the NGDO in the Cation community also generates a wave of participation in a country where solidarity is a characteristic of this people always ready to help their neighbor.</p>
        </div>
    @endif

    @if (session('language') === 'pt')
        <div>
            <h1>A nossa motivação</h1>
            <p>Em Catió, no ano de 2010, o professor Braima Sambu fez um pedido. Quando se esperaria que seria algo para ele, o que Braima pediu foi capacitação para a população da sua terra. Capacitar é tornar capaz, mas também permitir acreditar. A capacitação que falava era ajuda para os professores de Catió.</p>
            <p>Sensibilizados com tal pedido, no regresso a Portugal, começaram a reunir-se esforços para responder a este apelo.</p>
            <p>Desde esse momento, sempre com o lema “A Educação é o Único Caminho” um longo percurso tem sido trilhado. O projeto que começou com o objetivo de ajudar a melhorar as condições dos professores de Catió tem vindo a crescer atingido agora muitas outras áreas para além das escolas como o orfanato da “Casa da Mamé”, o “Centro de Educação Especial e Terapêutica”, o apoio ao hospital regional da região, entre muitas outras contribuições para o sector de Tombali.</p>
        </div>
    @elseif (session('language') === 'en')
        <div>
            <h1>Our motivation</h1>
            <p>In Catió, in 2010, Professor Braima Sambu made a request. When it was expected that it would be something for him, what Braima asked for was training for the population of his land. Empowering is to make capable, but also to allow belief. The empowerment he spoke of was help for the teachers of Catió.</p>
            <p>Sensitized by such a request, upon returning to Portugal, efforts began to be made to respond to this call.</p>
            <p>From that moment on, always with the motto “Educação é o Único Caminho" (Education is the Only Way) a long journey has been traveled. The project that began with the aim of helping to improve the conditions of the teachers of Catió has been growing, now reaching many other areas beyond schools such as the orphanage of “Casa da Mamé”, the “Special and Therapeutic Education Center”, support for the regional hospital in the region, among many other contributions to the Tombali sector.</p>
        </div>
    @endif
</x-margins-text>
