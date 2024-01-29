<?php

use function Livewire\Volt\{state, rules};

state(['title']);
state(['body']);
state(['recipient']);
state(['send_date']);

rules([
    'title' => ['required', 'string', 'min:5'],
    'body' => ['required', 'string', 'min:20'],
    'recipient' => ['required', 'email'],
    'send_date' => ['required', 'date'],
]);

$submit = function () {
    $this->validate();

    auth()
        ->user()
        ->notes()
        ->create([
            'title' => $this->title,
            'body' => $this->body,
            'recipient' => $this->recipient,
            'send_date' => $this->send_date,
        ]);

    redirect(route('notes.index'));
};

?>

<form class="flex flex-col justify-end gap-4 p-6 bg-white rounded-lg">
    <x-input wire:model='title' label="Note title" placeholder="It's been a great day." />
    <x-textarea wire:model='body' label="Your note" placeholder="Share all your thoughts with your friend." />
    <x-input wire:model='recipient' label="Recipient" icon="user" placeholder="yourfriend@email.com" />
    <x-input wire:model='send_date' label="Send date" type="date" icon="calendar" />
    <div>
        <x-button wire:click='submit' right-icon="calendar" primary spinner>Schedule note</x-button>
    </div>

    <x-errors />
</form>
