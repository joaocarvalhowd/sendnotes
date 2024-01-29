<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create a note') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <x-button icon="arrow-left" href="{{route('notes.index')}}" wire:navigate class="mb-6">All notes</x-button>
            <livewire:notes.create-note />
        </div>
    </div>
</x-app-layout>
