<x-guestLayout>

    @if (session('language') === 'pt')
        @section('social_description', 'Construir Pontes: A Jornada de Estudantes da Guiné-Bissau')
    @elseif (session('language') === 'en')
        @section('social_description', 'Building Bridges: The Journey of Students from Guinea-Bissau')
    @endif
    @section('social_image', '/stories/2024/12/natal_estudantes/todos_natal.jpg')

    <x-margins-text>
        @if (session('language') === 'pt')
            <h1>Construir Pontes: A Jornada de Estudantes da Guiné-Bissau</h1>
            <p class="text-gray-500 dark:text-gray-400">Por <x-person>David Freitas</x-person></p>
            <p class="text-sm text-gray-500 dark:text-gray-400">25 de dezembro de 2024</p>
        @elseif (session('language') === 'en')
            <h1>Building Bridges: The Journey of Students from Guinea-Bissau</h1>
            <p class="text-gray-500 dark:text-gray-400">By <x-person>David Freitas</x-person></p>
            <p class="text-sm text-gray-500 dark:text-gray-400">December 25, 2024</p>
        @endif


        @if (session('language') === 'pt')
            <p>Vivemos num mundo que se desdobra em múltiplas dimensões, muitas vezes segmentadas pelo eixo norte-sul global. O acesso à educação, à saúde e às oportunidades é frequentemente clivado por esta linha imaginária, que separa realidades e experiências de vida.</p>
            <p>A "Na Rota dos Povos" (NRP), no seu compromisso com a promoção da educação e do desenvolvimento, tem apoiado jovens guineenses a estudar em Portugal, proporcionando-lhes oportunidades de crescimento e aprendizagem. Neste ano letivo, nove jovens vindos da região de Tombali, na Guiné-Bissau, tiveram a oportunidade de estudar em Portugal, graças a bolsas de estudo e parcerias estabelecidas com a NRP.</p>
            <p>Aproveitando a interrupção letiva de Natal, quisemos conhecer a experiência destes jovens guineenses a estudar em Portugal. Entre desafios de adaptação, sonhos para o futuro e recordações de casa, partilharam connosco um pouco das suas histórias, refletindo sobre o significado de passarem esta época festiva longe das suas famílias. </p>
        @elseif (session('language') === 'en')
            <p>We live in a world that unfolds in multiple dimensions, often segmented by the global north-south axis. Access to education, health, and opportunities is often cleaved by this imaginary line, which separates realities and life experiences.</p>
            <p>"Na Rota dos Povos" (NRP), in its commitment to promoting education and development, has supported young students from Guinea-Bissau to study in Portugal, providing them with opportunities for growth and learning. In this school year, nine students from the Tombali region in Guinea-Bissau had the opportunity to study in Portugal, thanks to scholarships and partnerships established with NRP.</p>
            <p>During the Christmas break, we wanted to learn about the experience of these young Guineans studying in Portugal. Between adaptation challenges, dreams for the future, and memories of home, they shared with us a little of their stories, reflecting on the meaning of spending this festive season away from their families.</p>
        @endif

        @if (session('language') === 'pt')
            <h2>A adaptação a Portugal</h2>
        @elseif (session('language') === 'en')
            <h2>Adapting to Portugal</h2>
        @endif

        <figure class="float-right my-4 md:ml-4 w-[420]">
            <img src="{{ asset('/stories/2024/12/natal_estudantes/todos_natal.jpg') }}" alt="Os jovens com a voluntaria Liliana junto de uma árvore de Natal." class="object-cover  rounded m-auto">
            <figcaption class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                @if (session('language') === 'pt')
                    O Natal não era celebrado por todos, mas as saudades vivem em todos eles.
                @elseif (session('language') === 'en')
                    Christmas was not celebrated by all of them, but the longing lives in all of them.
                @endif
            </figcaption>
        </figure>

        @if (session('language') === 'pt')
            <p>O processo de adaptação foi marcado por dificuldades iniciais relacionadas com a língua, o clima e diferenças culturais. No entanto, o acolhimento das pessoas, a participação em atividades locais e o apoio de colegas e professores foram fundamentais para superar esses obstáculos. A convivência com uma realidade mais organizada e tecnologicamente avançada trouxe lições importantes sobre resiliência e crescimento pessoal.</p>
            <p>A <x-person>Tânia</x-person> descreve que encontrou uma realidade completamente diferente assim que chegou ao aeroporto, algo que só tinha visto na televisão.</p>
            <p>A dificuldade de lidar com o clima é um dos aspetos mais destacados. Mesmo com temperaturas mais elevadas do que é habitual para a época, o calor que se sente na Guiné-Bissau abraça bem mais forte do que aquele que se sente em Portugal. Esta já não é a primeira vez que a NRP apoia estudantes guineenses a estudar em Portugal, e no passado já vi jovens a usarem camisolas de gola alta no verão. O inverno para eles, faz apertar ainda mais as saudades.</p>
            <p><x-person>Hélder</x-person> e <x-person>Liliana</x-person>, dois voluntários da NRP, têm acompanhado estes jovens de mais perto. Hélder destaca a audácia de quem deixa o seu país abraçando este desafio e luta todos os dias para ultrapassar as dificuldades de viver num mundo completamente diferente, em que as coisas mais simples para nós, são muitas vezes um desafio para eles.</p>
            <p><x-person>Hélder</x-person> e <x-person>Liliana</x-person> destacam que orientá-los é uma tarefa difícil, devido às grandes diferenças culturais, mas que eles vão compensando com a atenção que vão prestando e preocupação que demonstram.</p>
        @elseif (session('language') === 'en')
            <p>The adaptation process was marked by initial difficulties related to language, climate, and cultural differences. However, the welcoming of people, participation in local activities, and the support of colleagues and teachers were essential to overcome these obstacles. Living in a more organized and technologically advanced reality brought important lessons about resilience and personal growth.</p>
            <p><x-person>Tânia</x-person> describes that she found a completely different reality as soon as she arrived at the airport, something she had only seen on television.</p>
            <p>The difficulty of dealing with the climate is one of the most highlighted aspects. Even with higher temperatures than usual for the season, the heat felt in Guinea-Bissau embraces much stronger than that felt in Portugal. This is not the first time that NRP has supported Guinean students to study in Portugal, and in the past, I have seen young people wearing turtlenecks in the summer. Winter for them makes the longing even tighter.</p>
            <p><x-person>Hélder</x-person> and <x-person>Liliana</x-person>, two NRP volunteers, have been accompanying these young people more closely. Hélder highlights the audacity of those who leave their country embracing this challenge and fighting every day to overcome the difficulties of living in a completely different world, where the simplest things for us are often a challenge for them.</p>
            <p><x-person>Hélder</x-person> and <x-person>Liliana</x-person> emphasize that guiding them is a difficult task, due to the great cultural differences, but they compensate with the attention they pay and the concern they show.</p>
        @endif


        @if (session('language') === 'pt')

            <h2>A Educação é o Único Caminho</h2>

            <p>O <x-a href="https://ods.pt/objectivos/4-educacao-de-qualidade/">Objetivo de Desenvolvimento Sustentável 4 (ODS4), "Educação de Qualidade"</x-a>, da Agenda 2030, tem como objetivo garantir o acesso à educação inclusiva, de qualidade e equitativa, promovendo oportunidades de aprendizagem ao longo da vida para todos. A NRP tem como moto "A Educação é o Único Caminho" e tem vindo a fornecer material escolar a cerca de 50 escolas na região de Tombali, alcançando cerca de <x-a href="https://www.publico.pt/2022/01/24/p3/noticia/rota-povos-vai-enviar-10-mil-estojos-escolares-guinebissau-1992891">10 mil alunos.</x-a></p>
            <p>O <x-person>Sadú</x-person> considera que a qualidade da educação é uma das mais importantes forças de Portugal e, certamente por isso, destacou que um dos momentos mais significativos da sua vida foi quando recebeu o visto para poder estudar em Portugal. Um processo que foi extremamente complexo e lento.</p>
            <p>O acesso à educação é um direito fundamental, mas que infelizmente está longe de ser uma realidade para muitas crianças e jovens em todo o mundo. <x-person>Titina</x-person> refere que, por ter três irmãos mais novos para sustentar, os seus pais não tinham a possibilidade de pagarem as propinas. A maioria das crianças só tem hipótese de estudar se os pais tiverem uma boa situação financeira, ou se as tabancas (aldeias) se organizarem, criando uma escola comunitária.</p>
            <p>A <x-person>Tânia</x-person> diz que não existe comparação possível entre as escolas Portuguesas e Guineenses, realçando que nas escolas da sua terra natal, a ilha de Como, estas não têm carteiras e que as crianças, nem têm um lápis para poderem escrever.</p>
            <p>Mesmo sem as condições ideais, os professores são muitas vezes uma salvação. <x-person>Mariama</x-person> perdeu a mãe com 16 anos e o pai com 17 anos, diz que o diretor da escola Canhe Na N'Tungué passou a ser o seu encarregado de educação.</p>
            <p><x-person>Hedigar</x-person> acrescenta que na Guiné-Bissau muitos professores dedicam as suas vidas ao trabalho, mas não recebem salários dignos, nem as condições ideais de vida. Considera que os professores carregam o futuro nos ombros, mas não recebem o respeito que merecem.</p>
        @elseif (session('language') === 'en')

            <h2>Education is the Only Way</h2>

            <p>The <x-a href="https://ods.pt/objectivos/4-educacao-de-qualidade/">Sustainable Development Goal 4 (SDG4), "Quality Education"</x-a>, of the 2030 Agenda, aims to ensure access to inclusive, quality, and equitable education, promoting lifelong learning opportunities for all. NRP's motto is "Education is the Only Way" and has been providing school supplies to about 50 schools in the Tombali region, reaching about <x-a href="https://www.publico.pt/2022/01/24/p3/noticia/rota-povos-vai-enviar-10-mil-estojos-escolares-guinebissau-1992891">10 thousand students.</x-a></p>
            <p><x-person>Sadú</x-person> considers that the quality of education is one of Portugal's most important strengths and, certainly for that reason, highlighted that one of the most significant moments of his life was when he received the visa to study in Portugal. A process that was extremely complex and slow.</p>
            <p>Access to education is a fundamental right, but unfortunately, it is far from being a reality for many children and young people around the world. <x-person>Titina</x-person> mentions that, because she has three younger siblings to support, her parents did not have the possibility to pay the tuition fees. Most children only have the opportunity to study if their parents have a good financial situation, or if the tabancas (villages) organize themselves, creating a community school.</p>
            <p><x-person>Tânia</x-person> says that there is no possible comparison between Portuguese and Guinean schools, emphasizing that in the schools of her homeland, the island of Como, they do not have desks and that the children do not even have a pencil to write with.</p>
            <p>Even without ideal conditions, teachers are often a salvation. <x-person>Mariama</x-person> lost her mother at 16 and her father at 17, says that the director of the school Canhe Na N'Tungué became her guardian.</p>
            <p><x-person>Hedigar</x-person> adds that in Guinea-Bissau many teachers dedicate their lives to work, but do not receive decent salaries or ideal living conditions. He considers that teachers carry the future on their shoulders, but do not receive the respect they deserve.</p>
        @endif

        <figure class="float-left my-2 md:mr-8 w-full md:w-[480px]">
            <img src="{{ asset('/stories/2024/12/natal_estudantes/natal_estudantes.png') }}" alt="Os jovens depois de receberem os seus vistos." class="object-cover rounded m-auto">
            <figcaption class="mt-1 text-sm text-gray-500 dark:text-gray-400 ">
                @if (session('language') === 'pt')
                    O dia em que receberam os vistos para estudarem em Portugal foi um momento inesquecível.
                @elseif (session('language') === 'en')
                    The day they received their visas to study in Portugal was an unforgettable moment.
                @endif
            </figcaption>
        </figure>

        @if (session('language') === 'pt')

            <p>Uma das coisas que mais marca estes jovens é a proximidade entre professores e alunos em Portugal. A forma como os estes estão sempre disponíveis e preocupados com o sucesso dos alunos é algo que valorizam muito. Como professor, não posso deixar de me sentir orgulhoso por saber que os meus colegas em Portugal estão a fazer a diferença na vida destes jovens. Não deixo também de refletir sobre a desvalorização que existe por parte de muitos dos alunos portugueses em relação à educação. Fiz parte da equipa que selecionou estes jovens e nem consigo descrever a dificuldade que senti em deslocar-me até às suas escolas, com caminhadas longas, pelo meio da lama e ao sol. Muitas destas caminhadas que têm de fazer terminam sem aulas, muitas vezes porque os professores estão em greve devido à falta de pagamento durante meses.</p>

            <p>Será que só valorizamos o que não temos? Devemos olhar para a educação como um direito ou um privilégio? Não deveria ser uma escolha.</p>
        @elseif (session('language') === 'en')

            <p>One of the things that most marks these young people is the proximity between teachers and students in Portugal. The way teachers are always available and concerned about the success of students is something they value very much. As a teacher, I cannot help but feel proud to know that my colleagues in Portugal are making a difference in the lives of these young people. I also cannot help but reflect on the devaluation that many Portuguese students have towards education. I was part of the team that selected these young people and I cannot even describe the difficulty I felt in going to their schools, with long walks, through the mud and in the sun. Many of these walks they have to make end without classes, often because teachers are on strike due to lack of payment for months.</p>

            <p>Do we only value what we do not have? Should we look at education as a right or a privilege? It should not be a choice.</p>
        @endif


        @if (session('language') === 'pt')

            <h2>O(s) presente(s) e o futuro</h2>

            <p>Sonhar é uma das características mais importantes dos seres humanos. Estes jovens sonham muito. Sonham com o futuro, mas principalmente com o dia em que poderão voltar às suas famílias. No mundo mais a norte, muitos de nós sonham com o presente. Ou com presentes. </p>

            <p>O <x-person>Sadú</x-person> acredita que quando não saímos da nossa zona de conforto, pensamos que o mundo acaba onde estamos e, por isso, não encaramos as dificuldades, não pensamos no nosso futuro. </p>

            <p>E no futuro o que gostariam eles de levar para a Guiné-Bissau?</p>

            <p>O <x-person>Hedigar</x-person> gostaria de levar tintas para poder pintar a sua escola, o <x-school>Liceu setorial de Como</x-school>. Querer pintar a nossa escola é querer crescer com a nossa comunidade. Ele gostaria ainda de tornar mais fácil o acesso ao hospital. A Guiné-Bissau é um dos países com uma das maiores taxas de mortalidade infantil e uma das mais elevadas taxas de mortalidade materna. Num estudo que a NRP ajudou a concretizar, verificou-se que o hospital regional de Catió tinha, em 2020, uma taxa de mortalidade materna perto de 1%. </p>

            <p>O <x-person>Sadú</x-person> e a <x-person>Mariama</x-person>, se pudessem, levariam máquinas para trabalhar a terra. A terra que tudo nos dá, mas que nem sempre tratamos bem. É importante voltarmos a tocar a terra, a cuidar dela. É urgente descalçar-nos e voltar a sentirmos a terra nos pés.</p>
        @elseif (session('language') === 'en')

            <h2>The Present(s) and the Future</h2>

            <p>Dreaming is one of the most important characteristics of human beings. These young people dream a lot. They dream of the future, but mainly of the day they can return to their families. In the world further north, many of us dream of the present. Or of presents.</p>

            <p><x-person>Sadú</x-person> believes that when we do not leave our comfort zone, we think the world ends where we are, and therefore, we do not face difficulties, we do not think about our future.</p>

            <p>And in the future, what would they like to take to Guinea-Bissau?</p>

            <p><x-person>Hedigar</x-person> would like to take paints to paint his school, the <x-school>Liceu setorial de Como</x-school>. Wanting to paint our school is wanting to grow with our community. He would also like to make access to the hospital easier. Guinea-Bissau is one of the countries with one of the highest infant mortality rates and one of the highest maternal mortality rates. In a study that NRP helped to carry out, it was found that the regional hospital of Catió had, in 2020, a maternal mortality rate close to 1%.</p>

            <p><x-person>Sadú</x-person> and <x-person>Mariama</x-person>, if they could, would take machines to work the land. The land that gives us everything, but that we do not always treat well. It is important to touch the land again, to take care of it. It is urgent to take off our shoes and feel the earth under our feet again.</p>
        @endif

        <figure class="my-8 w-full">
            <img src="{{ asset('/stories/2024/12/natal_estudantes/arroz_tania.jpg') }}" alt="A bolanha" class="rounded m-auto object-cover">
            <figcaption class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                @if (session('language') === 'pt')
                    O relação com o arroz é inseparável do quotidiano na Guiné-Bissau.
                @elseif (session('language') === 'en')
                    The relationship with rice is inseparable from everyday life in Guinea-Bissau.
                @endif
            </figcaption>
        </figure>

        @if (session('language') === 'pt')
            <p>A relação do povo guineense com o arroz é inseparável do quotidiano e uma história de esforço e tradição. Este come-se em qualquer altura do dia, e em qualquer refeição. Em Portugal, até já vi uma francesinha ser acompanhada de arroaz pelos nossos jovens. A <x-person>Tânia</x-person> reforça a importância de cultivar arroz. Este serve para pagar propinas, é uma das principais fontes de rendimento. Mas a relação não é fácil, trabalhar a bolanha (terreno pantanoso e fértil onde normalmente é cultivado o arroz) é uma tarefa bem dura. Lembro-me de um grupo de jovens que trabalhava a terra dizerem-me "Salva-me daqui, a bolanha está a matar-me".</p>
            <p>O <x-person>Olívio</x-person> gostaria de levar zinco para cobrir as casas da sua mãe e do seu irmão porque o telhado é feito de arbustos e na época chuvosa, não impede a chuva de entrar. É muito mais difícil sonhar quando a chuva nos acorda ao meio da noite. Sonha ainda com não voltar a ter fome.</p>
            <p>Todos eles gostariam de poderem no futuro contribuir para o desenvolvimento seu país e, talvez por isso, o que mais gostariam de levar de volta é a nossa escola.</p>
        @elseif (session('language') === 'en')
            <p>The relationship of the Guinean people with rice is inseparable from everyday life and a story of effort and tradition. It is eaten at any time of the day, and at any meal. In Portugal, I have even seen a francesinha accompanied by rice by our young people. <x-person>Tânia</x-person> reinforces the importance of cultivating rice. This serves to pay tuition fees, it is one of the main sources of income. But the relationship is not easy, working the bolanha (marshy and fertile land where rice is usually grown) is a very tough task. I remember a group of young people working the land telling me "Save me from here, the bolanha is killing me."</p>
            <p><x-person>Olívio</x-person> would like to take zinc to cover the houses of his mother and his brother because the roof is made of bushes and in the rainy season, it does not prevent the rain from entering. It is much more difficult to dream when the rain wakes us up in the middle of the night. He also dreams of never being hungry again.</p>
            <p>All of them would like to be able to contribute to the development of their country in the future and, perhaps for this reason, what they would most like to take back is our school.</p>
        @endif


        @if (session('language') === 'pt')
            <h2>Saudades</h2>
        @elseif (session('language') === 'en')
            <h2>Longing</h2>
        @endif


        <figure class="float-right my-4 md:ml-8 lg:w-80 ">
            <img src="{{ asset('/stories/2024/12/natal_estudantes/hedigar_mum.jpg') }}" alt="Mãe do Hedigar" class="rounded m-auto object-cover">
            <figcaption class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                @if (session('language') === 'pt')
                    Se pudesse trazer alguma coisa, o Hedigar não tem dúvida, traria a mãe.
                @elseif (session('language') === 'en')
                    If he could bring something, Hedigar has no doubt, he would bring his mother.
                @endif
            </figcaption>
        </figure>

        @if (session('language') === 'pt')

            <p>Uma das coisas que mais me marcou ao ouvir como estes jovens vêm o mundo foi lembrar-me que ainda há para quem a vida são as pessoas. Aqui por "cima", o mundo digitaliza-se e torna-se difícil sair dele. Perdemos nele as nossas crianças. Deixamo-las circular livremente no virtual e sobreprotegemo-las no mundo real. Ouvi recentemente o Professor Carlos Neto dizer que uma criança feliz tem os joelhos esfolados. O mundo virtual não deixa os joelhos esfolados, mas pode rasgar-nos a alma.</p>

            <p>Embora se diga que a palavra "saudade" é apenas Portuguesa, senti-la é universal. Se eles pudessem trazer alguma coisa para Portugal, a família seria o que colocariam na mala. O <x-person>Hedigar</x-person> não hesitaria e traria a sua mãe, embora a traga todos os dias no coração. O <x-person>Dino</x-person> traria o seu irmão, enquanto sonha em terminar o seu curso, para depois obter licenciatura e mestrado. </p>

            <p>A cultura Guineense também seria trazida por todos. A <x-person>Binta</x-person> descreve a cultura Guineense muito bem, adjectivando-a como vibrante. Quem tem a sorte de conhecer a Guiné-Bissau, compreende perfeitamente o que ela quer dizer. A música, a comida, a dança, a alegria, a cor, a vida.</p>

            <p>A <x-person>Titina</x-person> acrescenta que a dificuldade de passar esta quadra festiva longe da família torna-se ainda mais difícil porque sabem que na Guiné-Bissau também vão sentir saudades dela, em especial as suas irmãs. Sentir saudades de quem sente saudades de nós é uma dor agravada.</p>
        @elseif (session('language') === 'en')

            <p>One of the things that struck me the most when listening to how these young people see the world was remembering that there are still those for whom life is about people. Here "above", the world digitizes itself and it becomes difficult to leave it. We lose our children in it. We let them circulate freely in the virtual world and overprotect them in the real world. I recently heard Professor Carlos Neto say that a happy child has skinned knees. The virtual world does not leave skinned knees, but it can tear our soul apart.</p>

            <p>Although it is said that the word "saudade" is only Portuguese, feeling it is universal. If they could bring something to Portugal, family would be what they would put in the suitcase. <x-person>Hedigar</x-person> would not hesitate and would bring his mother, although he carries her in his heart every day. <x-person>Dino</x-person> would bring his brother, while dreaming of finishing his course, and then obtaining a degree and a master's degree.</p>

            <p>Guinean culture would also be brought by all. <x-person>Binta</x-person> describes Guinean culture very well, adjectivating it as vibrant. Those who are lucky enough to know Guinea-Bissau perfectly understand what she means. Music, food, dance, joy, color, life.</p>

            <p><x-person>Titina</x-person> adds that the difficulty of spending this festive season away from family becomes even more difficult because they know that in Guinea-Bissau they will also miss it, especially their sisters. Missing someone who misses us is an aggravated pain.</p>
        @endif

        @if (session('language') === 'pt')
            <h2>Histórias de Esperança</h2>

            <p>Os sonhos destes estudantes são inspiradores, aspiram a contribuir para o desenvolvimento da Guiné-Bissau, ajudando as suas comunidades, famílias e país. Planeiam aplicar os conhecimentos adquiridos, especialmente nas áreas de educação, saúde e agricultura. </p>
            <p>A esperança por si, não é uma arma, mas alimenta as principais formas de lutas pela conquista de direitos. <x-person>Roberto</x-person> destacou os direitos e a liberdade que se sente em Portugal. Tem como meta ser um bom homem estudioso para mais tarde ser um bom trabalhador. Realço o bom. De que serve toda a educação se não for para sermos bons?</p>
            <p>Os relatos pessoais destes jovens incluem momentos marcantes de superação e resiliência. Desde histórias de infância difíceis até o impacto de conseguir uma bolsa de estudos, cada estudante demonstra um forte compromisso em transformar as suas circunstâncias e criar um futuro melhor para si e para os seus.</p>
            <p>Realçam sempre que o sacrifício deles tem como objetivo ajudar a família e a comunidade. Precisamos mais de um mundo em que os sacrifícios não sejam apenas para proveito próprio, mas sirvam também para ajudar o próximo. </p>
        @elseif (session('language') === 'en')
            <h2>Stories of Hope</h2>

            <p>The dreams of these students are inspiring, aspiring to contribute to the development of Guinea-Bissau, helping their communities, families, and country. They plan to apply the knowledge acquired, especially in the areas of education, health, and agriculture.</p>
            <p>Hope itself is not a weapon, but it feeds the main forms of struggle for the conquest of rights. <x-person>Roberto</x-person> highlighted the rights and freedom felt in Portugal. His goal is to be a good man who studies to later be a good worker. I emphasize the good. What is the point of all education if it is not to be good?</p>
            <p>The personal accounts of these young people include striking moments of overcoming and resilience. From difficult childhood stories to the impact of obtaining a scholarship, each student demonstrates a strong commitment to transforming their circumstances and creating a better future for themselves and their families.</p>
            <p>They always emphasize that their sacrifice aims to help family and community. We need more of a world where sacrifices are not only for self-interest, but also serve to help others.</p>
        @endif

        <hr class="my-12"/>

        @if (session('language') === 'pt')

            <h2>Reflexão</h2>

            <p>1. O texto menciona o "eixo norte-sul global" e como este afeta o acesso à educação e à saúde. Achas que esta linha imaginária reflete uma realidade justa? Porquê?</p>
            <p>2. O lema da NRP é "A educação é o único caminho". Como achas que a educação pode transformar vidas e comunidades?</p>
            <p>3. A Tânia realça as diferenças entre as escolas da Guiné-Bissau e de Portugal. Que aspetos valorizas mais na tua escola e porquê?</p>
            <p>4. O Hedigar gostaria de levar tintas para pintar a escola da sua comunidade. Que ações podemos fazer, individualmente ou em grupo, para ajudar pessoas em situações semelhantes?</p>
            <p>5. O texto questiona se valorizamos o que temos. Como vês a educação: como um direito ou um privilégio? Justifica a tua resposta.</p>
            <p>6. Muitos jovens referem o desejo de contribuir para o desenvolvimento da sua comunidade. Que sonhos tens para o futuro e como podem beneficiar a sociedade em que vives?</p>
            <p>7. A saudade da família e da cultura é um tema forte no texto. Como achas que a distância da família e das tradições pode afetar a experiência de quem vive longe do seu país?</p>
            <p>8. O texto menciona vários Objectivos de Desenvolvimeto Sustentável (ODS). Qual destes objetivos achas que é mais urgente alcançar e porquê?</p>
        @elseif (session('language') === 'en')

            <h2>Reflection</h2>

            <p>1. The text mentions the "global north-south axis" and how it affects access to education and health. Do you think this imaginary line reflects a fair reality? Why?</p>
            <p>2. NRP's motto is "Education is the only way". How do you think education can transform lives and communities?</p>
            <p>3. Tânia highlights the differences between schools in Guinea-Bissau and Portugal. What aspects do you value most in your school and why?</p>
            <p>4. Hedigar would like to take paints to paint his community's school. What actions can we take, individually or as a group, to help people in similar situations?</p>
            <p>5. The text questions if we value what we have. How do you see education: as a right or a privilege? Justify your answer.</p>
            <p>6. Many young people mention the desire to contribute to the development of their community. What dreams do you have for the future and how can they benefit the society in which you live?</p>
            <p>7. Longing for family and culture is a strong theme in the text. How do you think the distance from family and traditions can affect the experience of those who live far from their country?</p>
            <p>8. The text mentions several Sustainable Development Goals (SDGs). Which of these goals do you think is most urgent to achieve and why?</p>
        @endif

        <hr class="my-12"/>

        @if (session('language') === 'pt')

            <h2>ODS 1: Erradicar a Pobreza</h2>
            <p>Referências a condições de vida precárias, famílias em situação de pobreza e o desejo de melhorar essas condições.</p>

            <h2>ODS 4: Educação de Qualidade</h2>
            <p>Enfatiza o valor da educação, tanto em Portugal quanto na Guiné-Bissau, destacando o desejo de levar melhorias ao sistema educacional guineense.</p>

            <h2>ODS 8: Trabalho Digno e Crescimento Económico</h2>
            <p>Aspirações de encontrar trabalho digno e contribuir para o desenvolvimento da Guiné-Bissau.</p>

            <h2>ODS 17: Parcerias para a Implementação dos Objetivos</h2>
            <p>O papel das bolsas de estudo e parcerias entre países (Guiné-Bissau e Portugal) para promover o desenvolvimento.</p>
        @elseif (session('language') === 'en')

            <h2>SDG 1: Eradicate Poverty</h2>
            <p>References to precarious living conditions, families in poverty, and the desire to improve these conditions.</p>

            <h2>SDG 4: Quality Education</h2>
            <p>Emphasizes the value of education, both in Portugal and in Guinea-Bissau, highlighting the desire to bring improvements to the Guinean educational system.</p>

            <h2>SDG 8: Decent Work and Economic Growth</h2>
            <p>Aspirations to find decent work and contribute to the development of Guinea-Bissau.</p>

            <h2>SDG 17: Partnerships for the Goals</h2>
            <p>The role of scholarships and partnerships between countries (Guinea-Bissau and Portugal) to promote development.</p>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 my-8">
            <img src="/images/ods/ods1.png" alt="ODS 1: Erradicar a Pobreza" class="rounded m-auto">
            <img src="/images/ods/ods4.png" alt="ODS 4: Educação de Qualidade" class="rounded m-auto">
            <img src="/images/ods/ods8.png" alt="ODS 8: Trabalho Digno e Crescimento Económico" class="rounded m-auto">
            <img src="/images/ods/ods17.png" alt="ODS 17: Parcerias para a Implementação dos Objetivos" class="rounded m-auto">
        </div>

        <hr class="my-12"/>

        <h2>Galeria</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-2 my-8">
            <figure>
                <img src="{{ asset('/stories/2024/12/natal_estudantes/dino.jpg') }}" alt="Dino e o seu irmão." class="rounded m-auto">
                <figcaption class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    @if (session('language') === 'pt')
                        Dino e o seu irmão.
                    @elseif (session('language') === 'en')
                        Dino and his brother.
                    @endif
                </figcaption>
            </figure>
            <figure>
                <img src="{{ asset('/stories/2024/12/natal_estudantes/todos.jpg') }}" alt="Dino e o seu irmão." class="rounded m-auto">
                <figcaption class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    @if (session('language') === 'pt')
                        Os jovens e os dois voluntários que acompanham com mais proximidade, o Hélder e a Liliana.
                    @elseif (session('language') === 'en')
                        The young people and the two volunteers who accompany them more closely, Hélder and Liliana.
                    @endif
                </figcaption>
            </figure>
        </div>

    </x-margins-text>

</x-guestLayout>
