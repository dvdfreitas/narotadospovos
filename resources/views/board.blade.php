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
                        <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Maria Alcina Jorge Almeida</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">1º Vice-Presidente</span> Filomena Maria Silva Ramos</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">2º Vice-Presidente</span> Rita Bandeira Coelho</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Secretária</span> Maria Manuela Fidalgo</li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Direção</h3>
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Susana Rute Ribeiro Ramos Antunes</li>
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
                        <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Ivone Carla dos Santos M. B. Vasco</li>
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

            <div class="bg-white border-l-4 border-nrp-blue shadow-sm rounded-r-xl overflow-hidden">
                <div class="bg-gray-50 px-8 py-5 border-b border-gray-100">
                    <p class="text-lg font-bold text-nrp-blue">
                        22 de Fevereiro 2025 a 31 de Dezembro 2025
                    </p>
                </div>

                <div class="p-8 grid md:grid-cols-3 gap-12">
                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Mesa da Assembleia Geral</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Tito Osvaldo Dias Baião</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">1º Vice-Presidente</span> Teresa Natália da Costa Leite Pinheiro</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">2º Vice-Presidente</span> Isabel Margarida da Silva Soares Lopes</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Secretária</span> Maria Manuela Fidalgo</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Direcção</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Susana Rute Ribeiro Ramos Antunes</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">1º Vice-Presidente</span> Fernando Manuel Lino Pinheiro</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">2º Vice-Presidente</span> Manuel Octávio Braga Soares Coelho</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Tesoureira</span> Anabela Fernanda Santos Bandeira de Sousa</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> David Correia Teixeira Freitas</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vogais</span> Maria Alcina Jorge Almeida<br>Rita Bandeira Coelho</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Conselho Fiscal</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Luis Armando Gonçalves Monteiro</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Ivone Carla dos Santos Miranda Branco Vasco</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vogais</span> Paula Alexandra Beirão Vieira<br>Luis Miguel Soares da Costa Seabra<br>Susana Isabel Duarte Teles Andrade</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-nrp-blue shadow-sm rounded-r-xl overflow-hidden">
                <div class="bg-gray-50 px-8 py-5 border-b border-gray-100">
                    <p class="text-lg font-bold text-nrp-blue">
                        28 de Maio 2022 a 21 de Fevereiro 2025
                    </p>
                </div>

                <div class="p-8 grid md:grid-cols-3 gap-12">
                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Mesa da Assembleia Geral</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Teresa Costa Pinheiro</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">1º Vice-Presidente</span> Manuel Rúben Sá Almeida (Cessou funções)</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">2º Vice-Presidente</span> Maria Cristina Cunha Leite</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Direcção</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Susana Rute Ribeiro Ramos Antunes</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">1º Vice-Presidente</span> Fernando Manuel Lino Pinheiro</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">2º Vice-Presidente</span> Manuel Octávio Coelho</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Tesoureiro</span> Ivone Carla dos Santos Branco Vasco</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Domingos Paulo Soares Lopes</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vogais</span> Anabela Bandeira Sousa<br>David Correia Teixeira Freitas<br>Maria Alcina Almeida<br>Rui Alberto Silva</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Suplente</span> Sandra Cristina Rocha Baptista</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Conselho Fiscal</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Luis Armando Monteiro</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Paula Alexandra Beirão Vieira</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vogais</span> Inês Lobo Pereira<br>Luis Miguel Soares Seabra<br>Susana Teles Andrade</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-nrp-blue shadow-sm rounded-r-xl overflow-hidden">
                <div class="bg-gray-50 px-8 py-5 border-b border-gray-100">
                    <p class="text-lg font-bold text-nrp-blue">
                        30 de Março 2019 a 27 de Maio 2022
                    </p>
                </div>

                <div class="p-8 grid md:grid-cols-3 gap-12">
                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Mesa da Assembleia Geral</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> António Júlio Montenegro Silva</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Maria Alcina Jorge Almeida</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Ivone Carla dos Santos Branco Vasco</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Direcção</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Tito Osvaldo Dias Baião</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Zélia Maria Fernandes Santos</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Manuel Octávio Coelho</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Tesoureiro</span> Susana Rute Ribeiro Ramos Antunes</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vogal</span> Fernando Manuel Lino Pinheiro</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Conselho Fiscal</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Alfredo Fonseca Vieira</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vogais</span> José Bernardo Sampaio Pimentel<br>Fernanda Isabel Silva</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-nrp-blue shadow-sm rounded-r-xl overflow-hidden">
                <div class="bg-gray-50 px-8 py-5 border-b border-gray-100">
                    <p class="text-lg font-bold text-nrp-blue">
                        2 de Abril 2016 a 29 de Março 2019
                    </p>
                </div>

                <div class="p-8 grid md:grid-cols-3 gap-12">
                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Mesa da Assembleia Geral</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> António Júlio Montenegro Silva</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Raquel Maria Moura Pacheco</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Arnaldo Saejo Baldé</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Direcção</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Tito Osvaldo Dias Baião</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Luis Armando Gonçalves Monteiro</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Zélia Maria Fernandes Santos</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Tesoureiro</span> Susana Rute Ribeiro Ramos Antunes</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vogal</span> Luis André Quinteiros</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Conselho Fiscal</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Alfredo Fonseca Vieira</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vogais</span> José Bernardo Sampaio Pimentel<br>António Sérgio Reis Ferreira</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-nrp-blue shadow-sm rounded-r-xl overflow-hidden">
                <div class="bg-gray-50 px-8 py-5 border-b border-gray-100">
                    <p class="text-lg font-bold text-nrp-blue">
                        8 de Setembro 2012 a 1 de Abril 2016
                    </p>
                </div>

                <div class="p-8 grid md:grid-cols-3 gap-12">
                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Mesa da Assembleia Geral</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> António Júlio Montenegro Silva</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Raquel Maria Moura Pacheco</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Arnaldo Saejo Baldé</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Direcção</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Tito Osvaldo Dias Baião</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> Luis Armando Gonçalves Monteiro</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Zélia Maria Fernandes Santos</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Tesoureiro</span> Susana Rute Ribeiro Ramos Antunes</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vogal</span> Luis André Quinteiros</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-sm text-gray-900 uppercase border-b border-gray-200 pb-2 mb-4">Conselho Fiscal</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Alfredo Fonseca Vieira</li>
                            <li><span class="block text-xs text-gray-400 font-semibold">Vogais</span> José Bernardo Sampaio Pimentel<br>António Sérgio Reis Ferreira</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-white border-l-4 border-nrp-blue shadow-sm rounded-r-xl overflow-hidden">
                <div class="bg-gray-50 px-8 py-5 border-b border-gray-100">
                    <p class="text-lg font-bold text-nrp-blue">
                        2 de Janeiro 2011 a 7 de Setembro 2012
                    </p>
                </div>

                <div class="p-8">
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Tito Osvaldo Dias Baião</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> João Pedro Silva Pereira</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Jorge Porfírio Dias Santos Silva</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Tesoureiro</span> Sónia Maria Crista Vieira</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vogal</span> Isabel Cristina Pires Dias</li>
                    </ul>
                </div>
            </div>

            <div class="bg-white border-l-4 border-nrp-blue shadow-sm rounded-r-xl overflow-hidden">
                <div class="bg-gray-50 px-8 py-5 border-b border-gray-100">
                    <p class="text-lg font-bold text-nrp-blue">
                        1 de Outubro 2007 a 1 de Janeiro 2011
                    </p>
                </div>

                <div class="p-8">
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Tito Osvaldo Dias Baião</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> João Pedro Silva Pereira</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Jorge Porfírio Dias Santos Silva</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Tesoureiro</span> Sónia Maria Crista Vieira</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vogal</span> Isabel Cristina Pires Dias</li>
                    </ul>
                </div>
            </div>

            <div class="bg-white border-l-4 border-nrp-blue shadow-sm rounded-r-xl overflow-hidden">
                <div class="bg-gray-50 px-8 py-5 border-b border-gray-100">
                    <p class="text-lg font-bold text-nrp-blue">
                        1 de Outubro 2004 a 30 de Setembro 2007
                    </p>
                </div>

                <div class="p-8">
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Tito Osvaldo Dias Baião</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> João Pedro Silva Pereira</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Jorge Porfírio Dias Santos Silva</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Tesoureiro</span> Sónia Maria Crista Vieira</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vogal</span> Isabel Cristina Pires Dias</li>
                    </ul>
                </div>
            </div>

            <div class="bg-white border-l-4 border-nrp-blue shadow-sm rounded-r-xl overflow-hidden">
                <div class="bg-gray-50 px-8 py-5 border-b border-gray-100">
                    <p class="text-lg font-bold text-nrp-blue">
                        2 de Outubro 2001 a 30 de Setembro 2004
                    </p>
                </div>

                <div class="p-8">
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li><span class="block text-xs text-gray-400 font-semibold">Presidente</span> Tito Osvaldo Dias Baião</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vice-Presidente</span> João Pedro Silva Pereira</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Secretário</span> Jorge Porfírio Dias Santos Silva</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Tesoureiro</span> Sónia Maria Crista Vieira</li>
                        <li><span class="block text-xs text-gray-400 font-semibold">Vogal</span> Isabel Cristina Pires Dias</li>
                    </ul>
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
