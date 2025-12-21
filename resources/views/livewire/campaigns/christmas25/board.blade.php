<?php
use function Livewire\Volt\{layout};

layout('layouts.guest');
?>

<div>

    <div class="max-w-7xl mx-auto px-4 py-8 min-h-screen flex flex-col gap-12">

        {{-- HEADER SECTION --}}
        @include('livewire.campaigns.christmas25.partials.board-header')

        {{-- DASHBOARD GRID --}}
        <main class="grid lg:grid-cols-12 gap-8 lg:h-[750px]">

            {{-- LEFT: Tree --}}
            <section class="lg:col-span-7 h-full min-h-[500px]">
                @livewire('campaigns.christmas25.progress-tree')
            </section>

            {{-- RIGHT: List --}}
            @include('livewire.campaigns.christmas25.partials.recent-panel')

        </main>

        {{-- DONATION OPTIONS --}}
        <section>
            @livewire('campaigns.christmas25.donation-options')
        </section>

    </div>

    {{-- MODAL --}}
    @livewire('campaigns.christmas25.donation-modal')

</div>
