<?php

use App\Models\Comment;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component {
    //
    #[validate('required|string')]
    public $comment;
    public $blogId;
    public Comment $commentaire;

    public function mount(Comment $comment)
    {
        $this->authorize('update', $comment);
        $this->commentaire = $comment;
        $this->blogId = $comment->blog_id;
        $this->comment = $comment->body;
    }

    public function saveComment()
    {
        $this->validate();
        $this->commentaire->update([
            'body' => $this->comment
        ]);
        $this->dispatch('commentSaved');
        $this->redirect(route('blogs.show',$this->blogId));

        $this->js("alert('comment saved')");
    }

    public function cancelEditing()
    {
        $this->redirect(route('blogs.show',$this->blogId));
    }

}; ?>


<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Update comment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 bg">
            <form wire:submit.prevent="saveComment('')" class="mt-4">
                <x-textarea
                    wire:model="comment"
                    rows="12"
                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-200 focus:outline-none"
                ></x-textarea>
                <div class="flex justify-end space-x-2 mt-2">
                    <x-button
                        type="submit"
                        label="Save"
                        right-icon="check"
                        flat
                        interaction="solid"
                        class="bg-blue-500 text-white hover:bg-blue-600"
                    />
                    <x-button
                        type="button"
                        label="Cancel"
                        wire:click="cancelEditing"
                        right-icon="trash"
                        outline hover="warning" focus:solid.gray
                    />
                </div>
            </form>
        </div>
    </div>
</div>
