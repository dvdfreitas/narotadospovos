<x-guestLayout>
    <x-banner-image image="/images/projects/ceet/ceet1.jpg" />

    <x-margins-text>

        @if (session('language') === 'pt')
            <h1>Centro de Educação Especial e Terapêutica (CEET)</h1>
        @elseif (session('language') === 'en')
            <h1>Special Education and Therapeutic Center (CEET in Portuguese)</h1>
        @endif

        @if (session('language') === 'pt')
            <p>O Centro de Educação Especial e Terapêutica foi inaugurado em fevereiro de 2023. É um centro totalmente equipado, dedicado ao diagnóstico, tratamento e melhoria da qualidade de vida de crianças com deficiência. Complementa a sua ação disponibilizando educação escolar básica e alimentação. Numa primeira fase, está a acolher 12 crianças com deficiência física e/ou desenvolvimento cognitivo prejudicado. São fornecidas a estas crianças terapias adequadas, educação especial, cuidados de saúde específicos e alimentação diária.</p>
            <p>A surdez e a cegueira são outras áreas de atuação esperadas.</p>
            <p>O espaço permite a realização de consultas e o acompanhamento online das crianças e dos terapeutas por médicos e outros técnicos de saúde a partir de Portugal.</p>
            <p>Dotamos já este espaço de equipamento diversificado, sem qualquer paralelo na Guiné-Bissau, um espaço funcional que permite a realização de consultas e o acompanhamento online das crianças e dos terapeutas por médicos e outros técnicos de saúde a partir de Portugal.</p>
            <p>De igual modo, vai a ser realizada a necessária formação de quadros locais a partir de Portugal e com a deslocação periódica de profissionais para formação in situ.</p>
            <p>As instalações de que dispomos são um grande orgulho para a Na Rota dos Povos, bem como os profissionais já recrutados e em processo de formação. Tal só foi possível pela presença e trabalho produtivo dos 2 jovens guineenses, licenciados no IPB (Instituto Politécnico de Bragança), e que regressaram a Catió integrando a equipa da Na Rota dos Povos local.</p>
        @elseif (session('language') === 'en')
            <p>The Special Education and Therapeutic Center was inaugurated in February 2023. It is a fully equipped center dedicated to the diagnosis, treatment, and improvement of the quality of life of children with disabilities. It complements its action by providing basic school education and food. In the first phase, it is hosting 12 children with physical and/or impaired cognitive development. These children are provided with appropriate therapies, special education, specific health care, and daily food.</p>
            <p>Deafness and blindness are other areas of expected action.</p>
            <p>The space allows for consultations and online monitoring of children and therapists by doctors and other health professionals from Portugal.</p>
            <p>We have already equipped this space with diversified equipment, without any parallel in Guinea-Bissau, a functional space that allows for consultations and online monitoring of children and therapists by doctors and other health professionals from Portugal.</p>
            <p>Similarly, the necessary training of local staff will be carried out from Portugal and with the periodic displacement of professionals for on-site training.</p>
            <p>The facilities we have are a great source of pride for Na Rota dos Povos, as are the professionals already recruited and in the training process. This was only possible due to the presence and productive work of the 2 young Guineans, graduates of IPB (Polytechnic Institute of Bragança), who returned to Catió integrating the local team of Na Rota dos Povos.</p>
        @endif
    </x-margins-text>

</x-guestLayout>
