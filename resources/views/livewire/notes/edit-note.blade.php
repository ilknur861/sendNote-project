<?php

use App\Models\Note;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new
#[Layout('layouts.app')]
class extends Component {
    //
    public $alertMessage;
    public $alertType;
    public Note $note;

    #[Validate('required|string|min:5')]
    public $noteTitle;

    #[Validate('required|string|min:20')]
    Public $noteBody;

    #[Validate('required|email')]
    public $noteRecipient;

    #[Validate('required|date')]
    public $noteSendDate;

    #[validate('required|bool')]
    public $noteIsPublished;

    public function mount(Note $note)
    {
        $this->authorize('update', $note);
        $this->fill($note);
        $this->noteTitle = $note->title;
        $this->noteBody = $note->body;
        $this->noteRecipient = $note->recipient;
        $this->noteSendDate = $note->send_date;
        $this->noteIsPublished = $note->is_published;
    }

    public function saveNote()
    {
        $this->validate();
        $this->note->update([
            'title'=>$this->noteTitle,
            'body'=>$this->noteBody,
            'recipient'=>$this->noteRecipient,
            'send_date'=>$this->noteSendDate,
            'is_published'=>$this->noteIsPublished
        ]);
        $this->dispatch('note-saved');
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit note') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form wire:submit="saveNote" class="space-y-4">
                    <x-input wire:model="noteTitle" label="Note Title" placeholder="It's been a great day"/>
                    <x-textarea wire:model="noteBody" label="Your Note"
                                placeholder="winter is not wintering this year"></x-textarea>
                    <x-input icon="user" wire:model="noteRecipient" type="email" label="Recipient"
                             placeholder="contact@uzziahlukeka.tech"/>
                    <x-input icon="calendar" wire:model="noteSendDate" type="date" label="Date"/>
                    <x-checkbox wire:model="noteIsPublished" label="Note published" />
                    <div class="flex justify-between pt-4">
                        <x-button type="submit" positive right-icon="calendar" spinner class="mt-4">
                            Save note
                        </x-button>
                        <x-button href="{{ route('notes.index') }}" flat negative>Back to Notes</x-button>
                    </div>
                    <x-action-message on="note-saved" />
                    <x-errors />
                </form>
            </div>

        </div>
    </div>
</div>



