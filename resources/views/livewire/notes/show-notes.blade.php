<?php

use function Livewire\Volt\{state};
use App\Models\Note;

state([
    'notes' => fn() => Auth::user()
        ->notes()
        ->orderBy('send_date', 'asc')
        ->get(),
]);

$delete = function ($id) {
    $note = Note::where('id', $id)->first();
    $this->authorize('delete', $note);
    $note->delete();

    $this->mount();
    $this->render();
};

?>

<div>
    @if ($notes->isEmpty())
        <div class="text-center">
            <p class="text-xl font-bold">No notes yet</p>
            <p class="text-sm">Let's create your first note to send.</p>
            <x-button primary icon-right="plus" class="mt-6" href="{{ route('notes.create') }}" wire:navigate>
                Create note
            </x-button>
        </div>
    @else
        <x-button primary icon-right="plus" class="mb-6" href="{{ route('notes.create') }}" wire:navigate>
            Create note
        </x-button>

        <div class="grid grid-cols-3 gap-4">
            @foreach ($notes as $note)
                <x-card wire:key='{{ $note->id }}'>
                    <div class="flex justify-between">
                        <div>
                            <a href="{{ route('notes.edit', $note) }}" wire:navigate
                                class="text-lg font-bold">{{ $note->title }}</a>
                            <p class="text-sm">{{ Str::limit($note->body, 30) }}</p>
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ \Carbon\Carbon::parse($note->send_date)->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="flex items-end justify-between gap-4 mt-4">
                        <p class="text-sm">Recipient: <span class="font-bold">{{ $note->recipient }}</span></p>
                        <div class="flex gap-1">
                            <x-button icon="eye" />
                            <x-button icon="trash" wire:click="delete('{{ $note->id }}')" />
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>
    @endif
</div>
