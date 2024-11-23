<x-guestLayout>

    <x-banner-image image="/images/projects/mame/mame1.jpg" />


    <x-margins-text>
        <h1>Casa da Mamé</h1>

        @if (session('language') === 'pt')
            <p>Perante a necessidade urgente de apoio às crianças cuja mãe morre durante o parto, a Na Rota dos Povos decidiu, em 2017, criar uma casa de acolhimento - a Casa da Mamé, que funciona na cidade de Catió. A Casa da Mamé é uma casa coração que acarinha estas crianças, permitindo-lhes ter alimentação, acesso à educação, possibilidade de brincar e ter um abraço de amor…é um verdadeiro lar. É gerida diariamente a partir de Portugal, e inteiramente financiada por donativos de Firquidjas (particulares e empresas).</p>
            <p>Um Firquidja é, em crioulo guineense, um membro da família que garante que tudo corre bem. Assim são também considerados todos que, generosamente, contribuem para que tudo corra bem a esta grande família na Casa Mamé.</p>
            <p>À data de Junho de 2023, a casa acolhe e tutela 19 crianças de ambos os sexos e diferentes idades. A ONGD dá emprego a 15 pessoas de Catió para garantir o correto funcionamento da casa, designadamente amas, cozinheira, lavadeira, coordenador e jardineiro, contribuindo para a sustentabilidade e desenvolvimento económico da região. </p>
        @elseif (session('language') === 'en')
            <p>Faced with the urgent need to support children whose mother dies during childbirth, Na Rota dos Povos decided, in 2017, to create a reception house - Casa da Mamé, which operates in the city of Catió. Casa da Mamé is a heart house that cherishes these children, allowing them to have food, access to education, the possibility of playing and having a hug of love… it is a true home. It is managed daily from Portugal, and entirely financed by donations from Firquidjas (individuals and companies).</p>
            <p>A Firquidja is, in Guinean Creole, a family member who ensures that everything goes well. Thus, all those who generously contribute to ensuring that everything goes well for this large family at Casa Mamé are also considered.</p>
            <p>As of June 2023, the house accommodates and guardians 19 children of both sexes and different ages. The NGDO employs 15 people from Catió to ensure the correct functioning of the house, including nurses, cooks, laundress, coordinator, and gardener, contributing to the sustainability and economic development of the region.</p>
        @endif
    </x-margins-text>
</x-guestLayout>
