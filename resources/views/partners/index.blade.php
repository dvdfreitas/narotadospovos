<x-guestLayout>
    @section('social_description', 'Parceiros — Na Rota dos Povos')

    @php($en = session('language') === 'en')

    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">

            <header class="mb-8 border-b border-gray-200 pb-7 sm:mb-10">
                <h1 class="m-0 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">{{ $en ? 'Partners' : 'Parceiros' }}</h1>
                <p class="mb-0 mt-3 max-w-2xl text-left text-base font-normal leading-relaxed text-slate-600">
                    @if ($en)
                        What Na Rota dos Povos has achieved is only possible thanks to many volunteers and
                        partners: companies, schools, associations and foundations who walk alongside us.
                    @else
                        O que a Na Rota dos Povos tem conseguido fazer só é possível graças a muitos voluntários
                        e parceiros: empresas, escolas, associações e fundações que caminham connosco.
                    @endif
                </p>
                <blockquote class="mb-0 mt-5 border-l-2 border-nrp-green pl-4 text-sm italic leading-relaxed text-slate-600">
                    @if ($en)
                        If you want to go fast, go alone. If you want to go far, go together.
                        <span class="mt-1 block text-xs font-semibold not-italic text-slate-500">African proverb</span>
                    @else
                        Se queres ir rápido, vai sozinho. Se queres ir longe, vai acompanhado.
                        <span class="mt-1 block text-xs font-semibold not-italic text-slate-500">Provérbio africano</span>
                    @endif
                </blockquote>
            </header>

            @if ($partners->isEmpty())
                <p class="text-slate-500">Ainda não há parceiros para mostrar.</p>
            @else
                <p class="mb-6 text-sm text-slate-500">
                    {{ $partners->count() }} {{ $en ? 'partners' : 'parceiros' }} ·
                    {{ $en ? 'click a logo to visit their website.' : 'clique num logótipo para visitar o site.' }}
                </p>

                <ul role="list" class="m-0 grid list-none grid-cols-2 gap-x-4 gap-y-8 p-0 sm:grid-cols-3 lg:grid-cols-5">
                    @foreach ($partners as $partner)
                        <li>
                            <x-partner :partner="$partner" :show-name="true" />
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-guestLayout>
