<?php
use function Livewire\Volt\{layout, state, mount, rules};
use App\Models\Note;

state(['note']);

state(['title']);
state(['body']);
state(['recipient']);
state(['send_date']);
state(['is_published']);

rules([
    'title' => ['required', 'string', 'min:5'],
    'body' => ['required', 'string', 'min:20'],
    'recipient' => ['required', 'email'],
    'send_date' => ['required', 'date'],
]);

mount(function (Note $note) {
    $this->authorize('update', $note);
    $this->fill($note);
    $this->title = $note->title;
    $this->body = $note->body;
    $this->recipient = $note->recipient;
    $this->send_date = $note->send_date;
    $this->is_published = $note->is_published;
});

$submit = function () {
    $this->validate();

    $this->note->update([
        'title' => $this->title,
        'body' => $this->body,
        'recipient' => $this->recipient,
        'send_date' => $this->send_date,
        'is_published' => $this->is_published,
    ]);

    $this->dispatch('note-saved');
};

layout('layouts.app');
?>

<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __(sprintf('Edit: %s', $note->title)) }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <form class="flex flex-col justify-end gap-4 p-6 bg-white rounded-lg">
            <x-input wire:model='title' label="Note title" placeholder="It's been a great day." />
            <x-textarea wire:model='body' label="Your note" placeholder="Share all your thoughts with your friend." />
            <x-input wire:model='recipient' label="Recipient" icon="user" placeholder="yourfriend@email.com" />
            <x-input wire:model='send_date' label="Send date" type="date" icon="calendar" />
            <x-checkbox wire:model='is_published' label="Is published?" />
            <div class="flex items-center justify-between">
                <x-button wire:click='submit' primary spinner>Save note</x-button>
                <x-button href="{{ route('notes.index') }}" wire:navigate flat negative>Back to notes</x-button>
            </div>

            <x-action-message on="note-saved" />

            <x-errors />
        </form>
    </div>
</div>
