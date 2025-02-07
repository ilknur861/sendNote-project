<?php

use App\Models\Blog;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {

    #[validate('required|string')]
    public $comment;
    public $userId;
    public $blogId;

    public function save()
    {
        $this->validate();
        auth()->user()->comments()->create([
            'blog_id' => $this->blogId,
            'body' => $this->comment,
        ]);
        $this->dispatch('commentAdded', $this->blogId);
        $this->reset('comment');
    }

    public function cancel()
    {
        $this->reset('comment');
    }

}; ?>

<div>
    <form wire:submit="save()" class="space-y-6">
        <x-textarea wire:model="comment" label="Comments" placeholder="write your notes"/>
        <div class="flex justify-between">
            <x-button type="submit" label="Save" right-icon="check" flat interaction:solid="positive"/>
            <x-button wire:click="cancel()" label="Cancel" right-icon="trash" outline hover="warning" focus:solid.gray/>
        </div>
    </form>
</div>
