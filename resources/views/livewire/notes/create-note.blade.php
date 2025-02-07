<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('required|string|min:5')]
    public $noteTitle;

    #[Validate('required|string|min:20')]
    Public $noteBody;

    #[Validate('required|email')]
    public $noteRecipient;

    #[Validate('required|date')]
    public $noteSendDate;

    #[Validate('required|bool')]
    public $noteIsPublished = false;

    public $alertMessage = null;
    public $alertType = null;

    public function submit()
    {
        $this->validate();

      auth()->user()->notes()->create([
          'title'=>$this->noteTitle,
          'body'=>$this->noteBody,
          'recipient'=>$this->noteRecipient,
          'send_date'=>$this->noteSendDate,
          'is_published'=>$this->noteIsPublished,
      ]);

      $this->alertMessage = 'Note has been successfully scheduled!';
      $this->alertType = 'success';

      $this->reset();
      $this->js("alert('Notes saved')");
      redirect(route('notes.index'));
    }

}; ?>

<div>

    @if ($alertMessage)
        <x-alert :title="$alertMessage" :warning="$alertType === 'error'" :positive="$alertType === 'success'" rounded="base" />
    @endif

    <form wire:submit="submit" class="space-y-4">
        <x-input wire:model="noteTitle" label="Note Title" placeholder="It's been a great day"/>
        <x-textarea wire:model="noteBody" label="Your Note"
                    placeholder="winter is not wintering this year"></x-textarea>
        <x-input icon="user" wire:model="noteRecipient" type="email" label="Recipient"
                 placeholder="contact@uzziahlukeka.tech"/>
        <x-input icon="calendar" wire:model="noteSendDate" type="date" label="Date"/>
        <x-checkbox wire:model="noteIsPublished" label="Published" />
        <x-button type="submit" positive right-icon="calendar" spinner class="mt-4">
            schedule note
        </x-button>
        <x-errors />
    </form>
</div>
