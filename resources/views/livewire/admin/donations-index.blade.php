<?php

use App\Enums\DonationStatus;
use App\Models\Donation;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

new #[Layout('layouts.app')] class extends Component {
    use WithPagination;

    // -------------------------------------------------------------------------
    // STATE
    // -------------------------------------------------------------------------

    public string $search = '';
    public bool $showSlideOver = false;
    public ?Donation $editingDonation = null;

    // Editable fields
    public string $editPublicMessage = '';
    public string $editGiftMessage = '';

    // -------------------------------------------------------------------------
    // LIFECYCLE & QUERY
    // -------------------------------------------------------------------------

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function with(): array
    {
        // Calculate stats for the top cards
        $stats = [
            'total_raised' => Donation::where('status', DonationStatus::Paid)->sum('amount'),
            'paid_count' => Donation::where('status', DonationStatus::Paid)->count(),
            'pending_count' => Donation::where('status', DonationStatus::Pending)->count(),
        ];

        return [
            'stats' => $stats,
            'donations' => Donation::query()
                ->with('payments')
                ->when($this->search, fn (Builder $q) => $q->where('donor_name', 'like', "%{$this->search}%")
                    ->orWhere('donor_email', 'like', "%{$this->search}%")
                    ->orWhere('donor_phone', 'like', "%{$this->search}%")
                    ->orWhere('id', 'like', "%{$this->search}%")
                )
                ->latest()
                ->paginate(10), // Reduced to 10 for better spacing
        ];
    }

    // -------------------------------------------------------------------------
    // ACTIONS
    // -------------------------------------------------------------------------

    public function openSlideOver(Donation $donation): void
    {
        $this->editingDonation = $donation;
        $this->editPublicMessage = $donation->campaign_data['public_message'] ?? '';
        $this->editGiftMessage = $donation->campaign_data['gift_message'] ?? '';
        $this->showSlideOver = true;
    }

    public function closeSlideOver(): void
    {
        $this->showSlideOver = false;
        $this->editingDonation = null;
    }

    public function updateDonation(): void
    {
        if (! $this->editingDonation) return;

        $data = $this->editingDonation->campaign_data;
        $data['public_message'] = $this->editPublicMessage;
        $data['gift_message'] = $this->editGiftMessage;

        $this->editingDonation->update(['campaign_data' => $data]);

        // Simple notification (Flash)
        session()->flash('message', 'Dados atualizados com sucesso.');
        $this->showSlideOver = false;
    }

    public function markAsPaid(int $id): void
    {
        // We find the donation manually to ensure we have the fresh instance
        $donation = Donation::find($id);

        if (! $donation) return;

        $donation->update([
            'status' => DonationStatus::Paid,
            'paid_at' => now(),
        ]);

        // Update the latest payment record if it exists
        $donation->payments()->latest()->first()?->update([
            'status' => DonationStatus::Paid,
            'provider_message' => 'Manual confirm by Admin',
        ]);

        // If we are editing this exact donation, refresh the object to update the UI
        if ($this->editingDonation && $this->editingDonation->id === $donation->id) {
            $this->editingDonation = $donation->fresh();
        }

        session()->flash('message', 'Donativo marcado como PAGO.');
    }
};
?>

<div class="min-h-screen bg-gray-50/50 pb-12">
    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 3000)"
            class="fixed top-4 right-4 z-50 rounded-lg bg-emerald-600 px-4 py-3 text-white shadow-lg transition"
        >
            {{ session('message') }}
        </div>
    @endif

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- HEADER & STATS --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">🎄 Dashboard Natal</h1>
            
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                {{-- Card 1: Total Raised --}}
                <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <dt class="truncate text-sm font-medium text-gray-500">Total Angariado</dt>
                    <dd class="mt-2 text-3xl font-bold tracking-tight text-emerald-600">{{ number_format($stats['total_raised'], 2) }} €</dd>
                </div>
                {{-- Card 2: Successful Donations --}}
                <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <dt class="truncate text-sm font-medium text-gray-500">Donativos Pagos</dt>
                    <dd class="mt-2 text-3xl font-bold tracking-tight text-gray-900">{{ $stats['paid_count'] }}</dd>
                </div>
                {{-- Card 3: Pending --}}
                <div class="overflow-hidden rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-900/5">
                    <dt class="truncate text-sm font-medium text-gray-500">Pendentes</dt>
                    <dd class="mt-2 text-3xl font-bold tracking-tight text-yellow-600">{{ $stats['pending_count'] }}</dd>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden">
            
            {{-- Toolbar --}}
            <div class="border-b border-gray-100 px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                <h2 class="font-semibold text-gray-800">Últimos Movimentos</h2>
                <div class="relative w-full sm:w-72">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input 
                        wire:model.live.debounce.300ms="search" 
                        type="search" 
                        placeholder="Pesquisar..." 
                        class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6"
                    >
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Info</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($donations as $donation)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 flex-shrink-0 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-xs font-bold">
                                            {{ substr($donation->donor_name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $donation->donor_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $donation->donor_email }}</div>
                                            <div class="text-[10px] text-gray-400">#{{ $donation->id }} • {{ $donation->created_at->format('d/m H:i') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $donation->amount }} €</div>
                                    <div class="text-xs text-gray-500 capitalize">{{ $donation->campaign_data['item_type'] ?? 'Item' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $status = $donation->status instanceof DonationStatus ? $donation->status->value : $donation->status;
                                        $badges = [
                                            'paid' => 'bg-green-50 text-green-700 ring-green-600/20',
                                            'pending' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
                                            'failed' => 'bg-red-50 text-red-700 ring-red-600/20',
                                            'cancelled' => 'bg-red-50 text-red-700 ring-red-600/20',
                                        ];
                                        $badgeClass = $badges[$status] ?? 'bg-gray-50 text-gray-600 ring-gray-500/10';
                                    @endphp
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badgeClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button 
                                        wire:click="openSlideOver({{ $donation->id }})"
                                        class="text-sm font-semibold text-emerald-600 hover:text-emerald-900 hover:underline"
                                    >
                                        Gerir
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                    Nenhum donativo encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                {{ $donations->links() }}
            </div>
        </div>
    </div>

    {{-- SLIDE-OVER (SIDE PANEL) --}}
    <div 
        x-data="{ open: @entangle('showSlideOver').live }"
        x-show="open"
        class="relative z-50"
        aria-labelledby="slide-over-title" 
        role="dialog" 
        aria-modal="true"
        style="display: none;"
    >
        {{-- Background backdrop --}}
        <div 
            x-show="open"
            x-transition:enter="ease-in-out duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            @click="open = false"
        ></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div 
                        x-show="open"
                        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:enter-start="translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full"
                        class="pointer-events-auto w-screen max-w-md"
                    >
                        @if($editingDonation)
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                            <div class="bg-emerald-700 px-4 py-6 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-base font-semibold leading-6 text-white" id="slide-over-title">
                                        Donativo #{{ $editingDonation->id }}
                                    </h2>
                                    <button wire:click="closeSlideOver" class="relative rounded-md text-emerald-200 hover:text-white focus:outline-none">
                                        <span class="absolute -inset-2.5"></span>
                                        <span class="sr-only">Fechar</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-1">
                                    <p class="text-sm text-emerald-100">{{ $editingDonation->donor_email }}</p>
                                </div>
                            </div>

                            <div class="relative flex-1 px-4 py-6 sm:px-6 space-y-8">
                                {{-- Status Action --}}
                                @if($editingDonation->status !== DonationStatus::Paid)
                                    <div class="rounded-lg bg-yellow-50 p-4 border border-yellow-200">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-yellow-800">Pagamento Pendente</h3>
                                                <div class="mt-2 text-sm text-yellow-700">
                                                    <p>Se o MB WAY falhar, podes validar manualmente aqui.</p>
                                                </div>
                                                <div class="mt-4">
                                                    <button 
                                                        wire:click="markAsPaid({{ $editingDonation->id }})"
                                                        wire:confirm="Confirmar pagamento manual? Isto é irreversível."
                                                        type="button" 
                                                        class="rounded-md bg-yellow-100 px-3 py-2 text-sm font-semibold text-yellow-800 shadow-sm hover:bg-yellow-200"
                                                    >
                                                        Marcar como Pago
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="rounded-lg bg-green-50 p-4 border border-green-200 flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">✓</div>
                                        <span class="font-bold text-green-800">Pagamento confirmado</span>
                                    </div>
                                @endif

                                {{-- Details --}}
                                <div>
                                    <h3 class="font-medium text-gray-900 border-b pb-2 mb-4">Detalhes Pessoais</h3>
                                    <dl class="space-y-4 text-sm">
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Nome</dt>
                                            <dd class="font-medium text-gray-900">{{ $editingDonation->donor_name }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Telemóvel</dt>
                                            <dd class="font-medium text-gray-900">{{ $editingDonation->donor_phone }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">NIF</dt>
                                            <dd class="font-medium text-gray-900">{{ $editingDonation->nif ?? '-' }}</dd>
                                        </div>
                                        <div class="flex justify-between">
                                            <dt class="text-gray-500">Anónimo</dt>
                                            <dd class="font-medium text-gray-900">{{ $editingDonation->is_anonymous ? 'Sim' : 'Não' }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                {{-- Edit Messages --}}
                                <div>
                                    <h3 class="font-medium text-gray-900 border-b pb-2 mb-4">Editar Conteúdo</h3>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium leading-6 text-gray-900">Mensagem Pública</label>
                                            <div class="mt-2">
                                                <textarea wire:model="editPublicMessage" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-emerald-600 sm:text-sm sm:leading-6"></textarea>
                                            </div>
                                        </div>

                                        @if($editingDonation->campaign_data['is_gift'] ?? false)
                                            <div>
                                                <label class="block text-sm font-medium leading-6 text-purple-900">Mensagem do Postal (Presente)</label>
                                                <div class="mt-2">
                                                    <textarea wire:model="editGiftMessage" rows="4" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-purple-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-600 sm:text-sm sm:leading-6"></textarea>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-shrink-0 justify-end px-4 py-4 bg-gray-50 border-t border-gray-100">
                                <button wire:click="closeSlideOver" type="button" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancelar</button>
                                <button wire:click="updateDonation" type="submit" class="ml-4 inline-flex justify-center rounded-md bg-emerald-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600">Guardar</button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>