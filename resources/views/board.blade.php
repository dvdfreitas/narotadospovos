<x-guestLayout>

    <x-margins-text>

        <div class="mb-12 border-b-2 border-gray-100 pb-4">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                @if (session('language') === 'pt')
                    Órgãos sociais
                @elseif (session('language') === 'en')
                    Board
                @endif
            </h1>
        </div>

        <div class="bg-white border-l-4 border-nrp-blue shadow-lg rounded-r-xl overflow-hidden mb-16">
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-100">
                <p class="text-xl font-bold text-nrp-blue">
                    1 de Janeiro de 2026 a 31 de Dezembro de 2028
                </p>

            </div>

            <div class="p-8 grid md:grid-cols-3 gap-12">
                <div>
                    <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Assembleia Geral</h3>
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> <span class="font-bold text-gray-900 text-base">Maria Alcina Jorge Almeida</span></li>
                        <li><span class="block text-xs text-gray-400 font-semibold">1º Vice-Presidente</span> Filomena Maria Silva Ramos</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">2º Vice-Presidente</span> Rita Bandeira Coelho</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Secretária</span> Maria Manuela Fidalgo</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-sm text-nrp-blue uppercase border-b border-nrp-blue/30 pb-2 mb-4">Direção</h3>
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> <span class="font-bold text-gray-900 text-lg">Susana Rute Ribeiro Ramos Antunes</span></li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Manuel Octávio Braga Soares Coelho</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Mário José Gomes Gouveia</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Tesoureiro</span> Tito Osvaldo Dias Baião</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Secretária</span> Anabela Fernanda Santos Bandeira de Sousa</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vogais</span> Isabel Margarida da Silva Soares Lopes<br>Maria Constança Moreira Dias Gouveia</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Suplente</span> Ilidio Manuel de Sousa Neto</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Conselho Fiscal</h3>
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> <span class="font-bold text-gray-900 text-base">Ivone Carla dos Santos M. B. Vasco</span></li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Alfredo da Fonseca Vieira</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vogais</span> Abel Alvaro Duarte Gomes<br>Luis Miguel Soares da Costa Seabra<br>Susana Isabel Duarte Teles Andrade</li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="flex items-center gap-4 mb-8">
            <span class="text-sm font-bold uppercase tracking-widest text-gray-400">Histórico</span>
            <div class="h-px bg-gray-200 flex-grow"></div>
        </div>


        <div class="space-y-6">

            <div class="border-2 border-nrp-blue rounded-lg p-6 bg-white">
                <p class="font-bold text-lg text-gray-900 mb-4">22 de Fevereiro 2025 a 31 de Dezembro 2025</p>

                <div class="mb-4">
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">MESA DA ASSEMBLEIA GERAL</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Tito Osvaldo Dias Baião</p>
                        <p>1º Vice-Presidente: Teresa Natália da Costa Leite Pinheiro</p>
                        <p>2º Vice-Presidente: Isabel Margarida da Silva Soares Lopes</p>
                        <p>Secretária: Maria Manuela Fidalgo</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">DIRECÇÃO</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Susana Rute Ribeiro Ramos Antunes</p>
                        <p>1º Vice-Presidente: Fernando Manuel Lino Pinheiro</p>
                        <p>2º Vice-Presidente: Manuel Octávio Braga Soares Coelho</p>
                        <p>Tesoureira: Anabela Fernanda Santos Bandeira de Sousa</p>
                        <p>Secretário: David Correia Teixeira Freitas</p>
                        <p>Vogal: Maria Alcina Jorge Almeida</p>
                        <p>Vogal: Rita Bandeira Coelho</p>
                    </div>
                </div>

                <div>
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">CONSELHO FISCAL</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Luis Armando Gonçalves Monteiro</p>
                        <p>Vice-Presidente: Ivone Carla dos Santos Miranda Branco Vasco</p>
                        <p>Vogal: Paula Alexandra Beirão Vieira</p>
                        <p>Vogal: Luis Miguel Soares da Costa Seabra</p>
                        <p>Vogal: Susana Isabel Duarte Teles Andrade</p>
                    </div>
                </div>
            </div>

            <div class="border-2 border-nrp-blue rounded-lg p-6 bg-white">
                <p class="font-bold text-lg text-gray-900 mb-4">28 de Maio 2022 a 21 de Fevereiro 2025</p>

                <div class="mb-4">
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">MESA DA ASSEMBLEIA GERAL</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Teresa Costa Pinheiro</p>
                        <p>1º Vice-Presidente: Manuel Rúben Sá Almeida (Cessou funções)</p>
                        <p>2º Vice-Presidente: Maria Cristina Cunha Leite</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">DIRECÇÃO</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Susana Rute Ribeiro Ramos Antunes</p>
                        <p>1º Vice-Presidente: Fernando Manuel Lino Pinheiro</p>
                        <p>2º Vice-Presidente: Manuel Octávio Coelho</p>
                        <p>Tesoureiro: Ivone Carla dos Santos Branco Vasco</p>
                        <p>Secretário: Domingos Paulo Soares Lopes</p>
                        <p>Vogal: Anabela Bandeira Sousa</p>
                        <p>Vogal: David Correia Teixeira Freitas</p>
                        <p>Vogal: Maria Alcina Almeida</p>
                        <p>Vogal: Rui Alberto Silva</p>
                        <p>Suplente: Sandra Cristina Rocha Baptista</p>
                    </div>
                </div>

                <div>
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">CONSELHO FISCAL</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Luis Armando Monteiro</p>
                        <p>Vice-Presidente: Paula Alexandra Beirão Vieira</p>
                        <p>Vogal: Inês Lobo Pereira</p>
                        <p>Vogal: Luis Miguel Soares Seabra</p>
                        <p>Vogal: Susana Teles Andrade</p>
                    </div>
                </div>
            </div>

            <div class="border-2 border-nrp-blue rounded-lg p-6 bg-white">
                <p class="font-bold text-lg text-gray-900 mb-4">30 de Março 2019 a 27 de Maio 2022</p>

                <div class="mb-4">
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">MESA DA ASSEMBLEIA GERAL</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: António Júlio Montenegro Silva</p>
                        <p>Vice-Presidente: Maria Alcina Jorge Almeida</p>
                        <p>Secretário: Ivone Carla dos Santos Branco Vasco</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">DIRECÇÃO</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Tito Osvaldo Dias Baião</p>
                        <p>Vice-Presidente: Zélia Maria Fernandes Santos</p>
                        <p>Secretário: Manuel Octávio Coelho</p>
                        <p>Tesoureiro: Susana Rute Ribeiro Ramos Antunes</p>
                        <p>Vogal: Fernando Manuel Lino Pinheiro</p>
                    </div>
                </div>

                <div>
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">CONSELHO FISCAL</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Alfredo Fonseca Vieira</p>
                        <p>Vogal: José Bernardo Sampaio Pimentel</p>
                        <p>Vogal: Fernanda Isabel Silva</p>
                    </div>
                </div>
            </div>

            <div class="border-2 border-nrp-blue rounded-lg p-6 bg-white">
                <p class="font-bold text-lg text-gray-900 mb-4">2 de Abril 2016 a 29 de Março 2019</p>

                <div class="mb-4">
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">MESA DA ASSEMBLEIA GERAL</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: António Júlio Montenegro Silva</p>
                        <p>Vice-Presidente: Raquel Maria Moura Pacheco</p>
                        <p>Secretário: Arnaldo Saejo Baldé</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">DIRECÇÃO</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Tito Osvaldo Dias Baião</p>
                        <p>Vice-Presidente: Luis Armando Gonçalves Monteiro</p>
                        <p>Secretário: Zélia Maria Fernandes Santos</p>
                        <p>Tesoureiro: Susana Rute Ribeiro Ramos Antunes</p>
                        <p>Vogal: Luis André Quinteiros</p>
                    </div>
                </div>

                <div>
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">CONSELHO FISCAL</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Alfredo Fonseca Vieira</p>
                        <p>Vogal: José Bernardo Sampaio Pimentel</p>
                        <p>Vogal: António Sérgio Reis Ferreira</p>
                    </div>
                </div>
            </div>

            <div class="border-2 border-nrp-blue rounded-lg p-6 bg-white">
                <p class="font-bold text-lg text-gray-900 mb-4">8 de Setembro 2012 a 1 de Abril 2016</p>

                <div class="mb-4">
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">MESA DA ASSEMBLEIA GERAL</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: António Júlio Montenegro Silva</p>
                        <p>Vice-Presidente: Raquel Maria Moura Pacheco</p>
                        <p>Secretário: Arnaldo Saejo Baldé</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">DIRECÇÃO</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Tito Osvaldo Dias Baião</p>
                        <p>Vice-Presidente: Luis Armando Gonçalves Monteiro</p>
                        <p>Secretário: Zélia Maria Fernandes Santos</p>
                        <p>Tesoureiro: Susana Rute Ribeiro Ramos Antunes</p>
                        <p>Vogal: Luis André Quinteiros</p>
                    </div>
                </div>

                <div>
                    <p class="font-semibold text-gray-800 uppercase text-sm mb-2">CONSELHO FISCAL</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>Presidente: Alfredo Fonseca Vieira</p>
                        <p>Vogal: José Bernardo Sampaio Pimentel</p>
                        <p>Vogal: António Sérgio Reis Ferreira</p>
                    </div>
                </div>
            </div>

            <div class="border-2 border-nrp-blue rounded-lg p-6 bg-white">
                <p class="font-bold text-gray-900 mb-3">2 de Janeiro 2011 a 7 de Setembro 2012</p>
                <div class="text-sm text-gray-600 space-y-1">
                    <p>Presidente: Tito Osvaldo Dias Baião</p>
                    <p>Vice-Presidente: João Pedro Silva Pereira</p>
                    <p>Secretário: Jorge Porfírio Dias Santos Silva</p>
                    <p>Tesoureiro: Sónia Maria Crista Vieira</p>
                    <p>Vogal: Isabel Cristina Pires Dias</p>
                </div>
            </div>

            <div class="border-2 border-nrp-blue rounded-lg p-6 bg-white">
                <p class="font-bold text-gray-900 mb-3">1 de Outubro 2007 a 1 de Janeiro 2011</p>
                <div class="text-sm text-gray-600 space-y-1">
                    <p>Presidente: Tito Osvaldo Dias Baião</p>
                    <p>Vice-Presidente: João Pedro Silva Pereira</p>
                    <p>Secretário: Jorge Porfírio Dias Santos Silva</p>
                    <p>Tesoureiro: Sónia Maria Crista Vieira</p>
                    <p>Vogal: Isabel Cristina Pires Dias</p>
                </div>
            </div>

            <div class="border-2 border-nrp-blue rounded-lg p-6 bg-white">
                <p class="font-bold text-gray-900 mb-3">1 de Outubro 2004 a 30 de Setembro 2007</p>
                <div class="text-sm text-gray-600 space-y-1">
                    <p>Presidente: Tito Osvaldo Dias Baião</p>
                    <p>Vice-Presidente: João Pedro Silva Pereira</p>
                    <p>Secretário: Jorge Porfírio Dias Santos Silva</p>
                    <p>Tesoureiro: Sónia Maria Crista Vieira</p>
                    <p>Vogal: Isabel Cristina Pires Dias</p>
                </div>
            </div>

            <div class="border-2 border-nrp-blue rounded-lg p-6 bg-white">
                <p class="font-bold text-gray-900 mb-3">2 de Outubro 2001 a 30 de Setembro 2004</p>
                <div class="text-sm text-gray-600 space-y-1">
                    <p>Presidente: Tito Osvaldo Dias Baião</p>
                    <p>Vice-Presidente: João Pedro Silva Pereira</p>
                    <p>Secretário: Jorge Porfírio Dias Santos Silva</p>
                    <p>Tesoureiro: Sónia Maria Crista Vieira</p>
                    <p>Vogal: Isabel Cristina Pires Dias</p>
                </div>
            </div>

        </div>


        <div class="relative mt-20">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900 to-gray-800 shadow-2xl rounded-2xl transform -skew-y-1"></div>

            <div class="relative bg-white p-10 rounded-xl border border-gray-200 shadow-xl text-center">
                <div class="inline-block p-3 rounded-full bg-gray-50 mb-4 border border-gray-100">
                    <svg class="w-8 h-8 text-nrp-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 mb-2">Sócios Fundadores</h3>
                <p class="text-xs font-bold text-nrp-blue tracking-[0.2em] uppercase mb-8">3 de Agosto de 2001</p>

                <div class="flex flex-wrap justify-center gap-x-8 gap-y-4 max-w-3xl mx-auto">
                    <span class="text-gray-700 font-medium px-4 py-2 bg-gray-50 rounded-lg border border-gray-100">Isabel Cristina Pires Dias</span>
                    <span class="text-gray-700 font-medium px-4 py-2 bg-gray-50 rounded-lg border border-gray-100">João Pedro Silva Pereira</span>
                    <span class="text-gray-700 font-medium px-4 py-2 bg-gray-50 rounded-lg border border-gray-100">Jorge Porfírio Dias Santos Silva</span>
                    <span class="text-gray-700 font-medium px-4 py-2 bg-gray-50 rounded-lg border border-gray-100">Sónia Maria Crista Vieira</span>
                    <span class="text-gray-700 font-medium px-4 py-2 bg-gray-50 rounded-lg border border-gray-100">Tito Osvaldo Dias Baião</span>
                </div>
            </div>
        </div>

    </x-margins-text>

</x-guestLayout>
