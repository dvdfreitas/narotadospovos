<?php

use App\Models\Partner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

/**
 * Todos os parceiros, visíveis ou não, e o painel para os acrescentar e
 * editar. Tudo numa página: quem acrescenta é alguém da ONGD, e é aqui que
 * vê o resultado.
 *
 * Esconder não apaga: o parceiro deixa de aparecer na página inicial e em
 * /partners, e volta com um clique.
 */
new #[Layout('layouts.app')] class extends Component {
    use WithFileUploads;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    /** '' todos, 'visible' ou 'hidden'. */
    #[Url(except: '')]
    public string $filter = '';

    // --- Painel ---------------------------------------------------------

    public bool $showForm = false;

    /** null a acrescentar; o id a editar. */
    public ?int $editingId = null;

    public string $name = '';
    public string $website = '';
    public string $facebook = '';
    public string $instagram = '';
    public string $linkedIn = '';
    public bool $visible = true;

    /** O ficheiro novo, enquanto não é gravado. */
    public $logo = null;

    /** O logótipo que já está gravado, ao editar. */
    public ?string $currentLogo = null;

    /** /admin/parceiros?novo=1 — é para onde /partners/create aponta. */
    public function mount(): void
    {
        if (request()->boolean('novo')) {
            $this->create();
        }
    }

    public function with(): array
    {
        $search = trim($this->search);

        return [
            'partners' => Partner::query()
                ->when($search !== '', fn (Builder $q) => $q->where('name', 'like', "%{$search}%"))
                ->when($this->filter === 'visible', fn (Builder $q) => $q->where('visible', true))
                ->when($this->filter === 'hidden', fn (Builder $q) => $q->where('visible', false))
                ->orderBy('name')
                ->get(),
            'visibleCount' => Partner::visible()->count(),
            'totalCount'   => Partner::count(),
        ];
    }

    /**
     * O can:admin da rota já é repetido pelo Livewire em cada pedido; a
     * verificação aqui não depende dessa configuração para valer.
     */
    public function toggle(int $id): void
    {
        abort_unless(Gate::allows('admin'), 403);

        $partner = Partner::findOrFail($id);
        $partner->update(['visible' => ! $partner->visible]);
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $partner = Partner::findOrFail($id);

        $this->resetForm();
        $this->editingId   = $partner->id;
        $this->name        = $partner->name;
        $this->website     = (string) $partner->website;
        $this->facebook    = (string) $partner->facebook;
        $this->instagram   = (string) $partner->instagram;
        $this->linkedIn    = (string) $partner->linkedIn;
        $this->visible     = $partner->visible;
        $this->currentLogo = $partner->logo;
        $this->showForm    = true;
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->resetForm();
    }

    /**
     * SVG fica de fora: é um ficheiro que pode levar código, e ficaria
     * servido a partir do nosso domínio.
     */
    public function save(): void
    {
        abort_unless(Gate::allows('admin'), 403);

        $data = $this->validate([
            'name'      => ['required', 'string', 'min:2', 'max:255', Rule::unique('partners', 'name')->ignore($this->editingId)],
            'logo'      => [$this->editingId || $this->currentLogo ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'website'   => ['nullable', 'url', 'max:255'],
            'facebook'  => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'linkedIn'  => ['nullable', 'url', 'max:255'],
            'visible'   => ['boolean'],
        ], [
            'name.required' => 'Indique o nome do parceiro.',
            'name.unique'   => 'Já existe um parceiro com este nome.',
            'logo.required' => 'Escolha o logótipo.',
            'logo.image'    => 'O logótipo tem de ser uma imagem.',
            'logo.mimes'    => 'O logótipo tem de ser JPG, PNG, WebP ou GIF.',
            'logo.max'      => 'O logótipo não pode passar de 2 MB.',
            '*.url'         => 'Este endereço não parece estar bem escrito. Comece por https://',
        ]);

        // Campos vazios guardam-se como null, não como texto vazio.
        $values = collect($data)->except('logo')->map(fn ($value) => $value === '' ? null : $value)->all();
        $values['slug'] = Str::slug($values['name']);

        if ($this->logo) {
            $values['logo'] = $this->logo->storeAs('', time() . '-' . $values['slug'] . '.' . $this->logo->extension(), 'partners');
        }

        if ($this->editingId) {
            Partner::findOrFail($this->editingId)->update($values);
            session()->flash('message', "{$values['name']} actualizado.");
        } else {
            Partner::create($values);
            session()->flash('message', "{$values['name']} acrescentado.");
        }

        $this->closeForm();
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'website', 'facebook', 'instagram', 'linkedIn', 'visible', 'logo', 'currentLogo']);
        $this->resetValidation();
    }
};
?>

<div class="bg-white">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" role="status"
            class="fixed right-4 top-4 z-50 rounded-lg bg-emerald-600 px-4 py-3 text-white shadow-lg">
            {{ session('message') }}
        </div>
    @endif

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">

        <header class="flex flex-wrap items-end justify-between gap-4 border-b border-gray-200 pb-6">
            <div>
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-900">← Painel</a>
                <h1 class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">Parceiros</h1>
                <p class="mt-2 text-gray-600">
                    {{ $visibleCount }} de {{ $totalCount }} visíveis no site. Esconder não apaga: volta a aparecer com um clique.
                </p>
            </div>
            <button type="button" wire:click="create" class="inline-flex items-center gap-1.5 rounded-lg bg-nrp-blue px-4 py-2 text-sm font-semibold text-white hover:bg-[#006c94]">
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M10 4v12M4 10h12" stroke-linecap="round" /></svg>
                Acrescentar parceiro
            </button>
        </header>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-wrap gap-2" role="group" aria-label="Filtrar">
                @foreach (['' => 'Todos', 'visible' => 'Visíveis', 'hidden' => 'Escondidos'] as $value => $label)
                    <button type="button" wire:click="$set('filter', '{{ $value }}')"
                        aria-pressed="{{ $filter === $value ? 'true' : 'false' }}"
                        @class([
                            'rounded-full px-4 py-1.5 text-sm font-medium ring-1 ring-inset',
                            'bg-nrp-blue text-white ring-nrp-blue' => $filter === $value,
                            'bg-white text-gray-700 ring-gray-300 hover:bg-gray-50' => $filter !== $value,
                        ])>{{ $label }}</button>
                @endforeach
            </div>

            <div class="relative w-full sm:w-72">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="search" aria-label="Pesquisar parceiros" placeholder="Pesquisar pelo nome…"
                    class="block w-full rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-nrp-blue sm:text-sm">
            </div>
        </div>

        @if ($partners->isEmpty())
            <p class="mt-10 text-center text-sm text-gray-500">Nenhum parceiro encontrado.</p>
        @else
            <ul role="list" class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($partners as $partner)
                    <li wire:key="partner-{{ $partner->id }}"
                        @class([
                            'flex items-center gap-4 rounded-xl p-4 ring-1 transition-colors',
                            'ring-gray-200' => $partner->visible,
                            'bg-gray-50 ring-gray-200' => ! $partner->visible,
                        ])>
                        <div @class(['flex h-16 w-24 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-white ring-1 ring-gray-100', 'opacity-40 grayscale' => ! $partner->visible])>
                            @if ($partner->logo)
                                <img src="{{ $partner->logoUrl() }}" alt="" loading="lazy" class="max-h-full max-w-full object-contain p-1.5">
                            @else
                                <span class="text-xs text-gray-400">Sem logótipo</span>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <p @class(['truncate font-medium', 'text-gray-900' => $partner->visible, 'text-gray-500' => ! $partner->visible])>{{ $partner->name }}</p>
                            @if ($partner->website)
                                <a href="{{ $partner->website }}" target="_blank" rel="noopener" class="block truncate text-xs text-gray-500 hover:text-nrp-blue">
                                    {{ preg_replace('#^https?://(www\.)?#', '', rtrim($partner->website, '/')) }}
                                </a>
                            @endif
                            <div class="mt-1 flex items-center gap-3 text-xs">
                                <span @class(['font-medium', 'text-emerald-700' => $partner->visible, 'text-gray-500' => ! $partner->visible])>
                                    {{ $partner->visible ? 'Visível no site' : 'Escondido' }}
                                </span>
                                <button type="button" wire:click="edit({{ $partner->id }})" class="font-medium text-nrp-blue hover:text-gray-900">
                                    Editar<span class="sr-only"> {{ $partner->name }}</span>
                                </button>
                            </div>
                        </div>

                        <button type="button" role="switch" wire:click="toggle({{ $partner->id }})"
                            aria-checked="{{ $partner->visible ? 'true' : 'false' }}"
                            aria-label="Mostrar {{ $partner->name }} no site"
                            @class([
                                'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-nrp-blue motion-reduce:transition-none',
                                'bg-emerald-600' => $partner->visible,
                                'bg-gray-300' => ! $partner->visible,
                            ])>
                            <span aria-hidden="true" @class([
                                'pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow ring-0 transition duration-200 motion-reduce:transition-none',
                                'translate-x-5' => $partner->visible,
                                'translate-x-0' => ! $partner->visible,
                            ])></span>
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- PAINEL: acrescentar ou editar --}}
    @if ($showForm)
        <div class="fixed inset-0 z-40 flex justify-end" role="dialog" aria-modal="true" aria-labelledby="partner-form-title"
            x-data x-on:keydown.escape.window="$wire.closeForm()">
            <div class="absolute inset-0 bg-gray-900/40" wire:click="closeForm"></div>

            <form wire:submit="save" class="relative flex h-full w-full max-w-lg flex-col bg-white shadow-xl">
                <div class="flex items-start justify-between border-b border-gray-100 px-6 py-5">
                    <div>
                        <h2 id="partner-form-title" class="text-lg font-semibold text-gray-900">
                            {{ $editingId ? 'Editar parceiro' : 'Acrescentar parceiro' }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">Aparece na página inicial e em /partners, com o logótipo e os links.</p>
                    </div>
                    <button type="button" wire:click="closeForm" aria-label="Fechar" class="rounded-md p-1 text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="m5 5 10 10M5 15 15 5" stroke-linecap="round" /></svg>
                    </button>
                </div>

                <div class="flex-1 space-y-6 overflow-y-auto px-6 py-6">
                    {{-- Logótipo --}}
                    <div>
                        <span class="block text-sm font-medium text-gray-900">Logótipo @unless ($editingId)<span class="text-red-600">*</span>@endunless</span>
                        <div class="mt-2 flex items-center gap-4">
                            <div class="flex h-20 w-28 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-gray-50 ring-1 ring-gray-200">
                                @if ($logo && method_exists($logo, 'isPreviewable') && $logo->isPreviewable())
                                    <img src="{{ $logo->temporaryUrl() }}" alt="" class="max-h-full max-w-full object-contain p-2">
                                @elseif ($currentLogo)
                                    <img src="/images/partners/{{ $currentLogo }}" alt="" class="max-h-full max-w-full object-contain p-2">
                                @else
                                    <svg class="h-8 w-8 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" /></svg>
                                @endif
                            </div>
                            <div>
                                <label for="partner-logo" class="inline-flex cursor-pointer items-center rounded-lg px-3 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-nrp-blue">
                                    {{ $currentLogo || $logo ? 'Trocar imagem' : 'Escolher imagem' }}
                                    <input id="partner-logo" type="file" wire:model="logo" accept="image/png,image/jpeg,image/webp,image/gif" class="sr-only"
                                        @error('logo') aria-invalid="true" aria-describedby="partner-logo-error" @enderror>
                                </label>
                                <p class="mt-1.5 text-xs text-gray-500">PNG, JPG, WebP ou GIF, até 2 MB. De preferência com fundo branco ou transparente.</p>
                                <p wire:loading wire:target="logo" class="mt-1 text-xs text-gray-500">A carregar…</p>
                            </div>
                        </div>
                        @error('logo') <p id="partner-logo-error" class="mt-2 text-sm text-red-700">{{ $message }}</p> @enderror
                    </div>

                    {{-- Nome --}}
                    <div>
                        <label for="partner-name" class="block text-sm font-medium text-gray-900">Nome <span class="text-red-600">*</span></label>
                        <input id="partner-name" type="text" wire:model="name" autocomplete="organization"
                            class="mt-2 block w-full rounded-lg border-0 py-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-nrp-blue sm:text-sm"
                            @error('name') aria-invalid="true" aria-describedby="partner-name-error" @enderror>
                        @error('name') <p id="partner-name-error" class="mt-2 text-sm text-red-700">{{ $message }}</p> @enderror
                    </div>

                    {{-- Links --}}
                    <fieldset>
                        <legend class="text-sm font-medium text-gray-900">Links <span class="font-normal text-gray-500">(opcionais)</span></legend>
                        <p class="mt-1 text-xs text-gray-500">No site, clicar no logótipo leva ao endereço do site.</p>
                        <div class="mt-3 space-y-3">
                            @foreach (['website' => 'Site', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedIn' => 'LinkedIn'] as $field => $label)
                                <div class="grid grid-cols-[6rem_1fr] items-center gap-3">
                                    <label for="partner-{{ $field }}" class="text-sm text-gray-700">{{ $label }}</label>
                                    <div>
                                        <input id="partner-{{ $field }}" type="url" wire:model="{{ $field }}" placeholder="https://"
                                            class="block w-full rounded-lg border-0 py-2 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-nrp-blue sm:text-sm"
                                            @error($field) aria-invalid="true" aria-describedby="partner-{{ $field }}-error" @enderror>
                                        @error($field) <p id="partner-{{ $field }}-error" class="mt-1 text-sm text-red-700">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

                    {{-- Visível --}}
                    <label class="flex items-start gap-3 rounded-lg bg-gray-50 p-4">
                        <input type="checkbox" wire:model="visible" class="mt-0.5 h-5 w-5 rounded border-gray-300 text-nrp-blue focus:ring-nrp-blue">
                        <span class="text-sm">
                            <span class="block font-medium text-gray-900">Mostrar no site</span>
                            <span class="text-gray-500">Desmarcado, fica guardado mas escondido até o ligar na lista.</span>
                        </span>
                    </label>
                </div>

                <div class="flex justify-end gap-3 border-t border-gray-100 px-6 py-4">
                    <button type="button" wire:click="closeForm" class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancelar</button>
                    <button type="submit" wire:loading.attr="disabled" wire:target="save, logo"
                        class="rounded-lg bg-nrp-blue px-4 py-2 text-sm font-semibold text-white hover:bg-[#006c94] disabled:opacity-60">
                        {{ $editingId ? 'Gravar alterações' : 'Acrescentar' }}
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
