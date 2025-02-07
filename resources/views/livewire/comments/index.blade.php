<?php

use App\Models\Comment;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public $comments;
    public $userId;
    public $blogId;

    public $editingCommentId; // Track which comment is being edited
    public $updatedBody = '';

    public function mount()
    {
        $this->loadComments();
    }

    #[On(['commentAdded', 'deleteComment', 'commentSaved'])]
    public function loadComments()
    {
        $this->comments = Comment::where('blog_id', $this->blogId)->get();
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('delete', $comment);
        $comment->delete();
        $this->dispatch('deleteComment');

        $this->js("alert('comment deleted')");
    }
};

?>

<div class="mt-4 space-y-4">
    @if($comments->isNotEmpty())
        @foreach($comments as $comment)
            <x-card wire:key="comment-{{ $comment->id }}">
                <div class="text-black p-4 rounded-lg shadow-md max-w-lg mx-auto">
                    <div class="flex items-center">
                        <!-- Profile Picture -->
                        <x-avatar xs/>
                        <div class="ml-3">
                            <!-- Username -->
                            <h4 class="font-semibold">{{ $comment->user->pseudo }}</h4>
                            <!-- Timestamp -->
                            <p class="text-gray-400 text-sm">
                                {{ \Carbon\Carbon::parse($comment->created_at)->format('D, d M Y') }}
                            </p>
                        </div>
                    </div>

                    <p class="mt-4 text-gray-500 leading-relaxed">{{ $comment->body }}</p>
                    @canany(['update', 'delete'], $comment)
                        <div class="flex space-x-4 mt-2">
                            <x-mini-button
                                href="{{ route('comment.edit',$comment->id) }}"
                                wire:navigate
                                rounded icon="pencil" flat gray interaction="positive"
                                wire:confirm="Are you sure you want to edit this comment?"
                                label="Edit"
                            />
                            <x-mini-button
                                wire:click="delete('{{ $comment->id }}')"
                                rounded icon="trash" flat gray interaction="negative"
                                wire:confirm="Are you sure you want to delete this comment?"
                                label="Delete"
                            />
                        </div>
                    @endcanany
                </div>
            </x-card>
        @endforeach
    @else
        <p class="text-blue-700">No comments found for this user and blog.</p>
    @endif
</div>




