<x-guestLayout>

    <x-banner-image image="/images/projects/health/health1.jpg" />

    <x-margins-text>
        @if (session('language') === 'pt')
            <h1>Apoio à saúde</h1>
        @elseif (session('language') === 'en')
            <h1>Health support</h1>
        @endif

        @if (session('language') === 'pt')
            <p>O Hospital Musna Sambú, em Catió, sofre de inúmeras e graves carências que, só não têm consequências mais gravosas graças à dedicação dos seus poucos médicos, enfermeiros, farmacêuticos e outros profissionais. O Hospital ainda não tem acesso a água potável nem energia elétrica, exceto no bloco operatório, onde tem um gerador de apoio, e no serviço de sangue e laboratório, onde têm energia fornecida por painéis solares.</p>
            <p>Os doentes internados têm de comprar os seus próprios medicamentos e providenciar a sua alimentação. Isto obriga a um enorme esforço das famílias dos doentes, que habitualmente ficam a viver nas instalações do hospital para poderem, assim, apoiar o seu familiar doente e cozinhar as suas refeições. A imagiologia e a estomatologia não funcionam e o laboratório é muito rudimentar.</p>
            <p>O nosso apoio traduz-se no aporte de vários medicamentos para uso interno, material médico e muitos consumíveis.</p>
            <p>Entregámos, na ala de enfermagem do hospital, um monitor de sinais vitais. Instalámos uma estação de reanimação neonatal. Colocámos ao serviço do hospital e da comunidade uma incubadora. Entregámos camas hospitalares com objetivo de melhor as condições e garantir o conforto dos doentes. Recuperamos a cisterna de água e o poço, e instalamos 4 pontos de acesso à água, uma vez que só existia um em todo o edifício.</p>
        @elseif (session('language') === 'en')
            <p>Musna Sambú Hospital in Catió suffers from numerous and serious deficiencies that only do not have more serious consequences thanks to the dedication of its few doctors, nurses, pharmacists, and other professionals. The Hospital still does not have access to drinking water or electricity, except in the operating block, where it has a support generator, and in the blood service and laboratory, where they have energy supplied by solar panels.</p>
            <p>Patients admitted have to buy their own medicines and provide their own food. This requires a huge effort from the patients' families, who usually stay living in the hospital facilities to be able to support their sick family member and cook their meals. Imaging and stomatology do not work, and the laboratory is very rudimentary.</p>
            <p>Our support translates into the provision of various medicines for internal use, medical material, and many consumables.</p>
            <p>We delivered a vital signs monitor to the nursing wing of the hospital. We installed a neonatal resuscitation station. We put an incubator at the service of the hospital and the community. We delivered hospital beds with the aim of improving conditions and ensuring patient comfort. We recovered the water cistern and the well, and installed 4 water access points, as there was only one in the entire building.</p>
        @endif
    </x-margins-text>

</x-guestLayout>
