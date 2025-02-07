<?php

use App\Models\Blog;
use Livewire\Volt\Component;

new class extends Component {
    //
    public $blogId ;

    protected $listeners = ['$listeners'=>'with'];

    public function with()
    {
        return [
            'blog'=>Blog::where('id',$this->blogId)
                ->first(),
        ];
    }

    public function deleteBlog()
    {
        try {
            $blog = Blog::find($this->blogId);
            if (!$blog) {
                throw new \Exception('Blog not found');
            }
            $this->authorize('delete', $blog);
            $blog->delete();

            session()->flash('alert', [
                'message' => 'Post successfully deleted.',
                'class' => 'alert-success',
                'status' => 'deleted',
                'type' => 'positive',
            ]);
            redirect(route('blogs'));
        } catch (\Exception $e) {
            session()->flash('alert', [
                'message' => 'An error occurred while deleting the blog: ' . $e->getMessage(),
                'class' => 'alert-danger',
                'status' => 'error',
                'type' => 'negative',
            ]);
            \Log::error('Error deleting blog post: ' . $e->getMessage());
            $this->js("alert('Failed to delete the post! Please try again.')");
        }
    }

};


?>

<div class="bg-gray-50 max-w-5xl mt-4">
    <x-card wire:key="{{ $blog->id }}">
        <div class="container mx-auto p-8 bg-white shadow-lg rounded-lg">
            @canany(['update','delete'],$blog)
                <div class="flex justify-end mb-3 space-x-2">
                    <x-button
                        href="{{ route('blog.edit',$blog->id) }}"
                        wire:navigate
                        label="Edit"
                        right-icon="pencil"
                        flat
                        interaction="solid"
                        class="bg-blue-500 text-white hover:bg-blue-600"
                    />
                    <x-button
                        type="button"
                        label="delete"
                        wire:click="deleteBlog"
                        right-icon="trash"
                        outline hover="warning" focus:solid.gray
                        wire:confirm="Are you sure you want to delete this blog?"
                    />
                </div>
            @endcanany
            <!-- Image Slot -->
            <div class="w-full h-64 bg-gray-200 rounded-lg overflow-hidden mb-6">
                <img src="{{ asset('storage/' . $blog->photo) }}" alt="Blog Photo" class="w-full h-full object-cover rounded-t-lg">
            </div>
            <div class="flex justify-between">
                <h1 class="text-5xl font-extrabold text-gray-800">{{ $blog->title }}</h1>
                <p class="mt-4 text-sm text-gray-500">
                    <x-badge info label="{{ $blog->categories}}" />
                </p>
            </div>

            <p class="mt-4 text-sm text-gray-500">
                Posted {{ \Carbon\Carbon::parse($blog->created_at)->format('D, d M Y') }} -
                <a href="#" class="text-blue-600 hover:underline">À Propos</a> -
                By <span class="font-semibold">{{ $blog->author }}</span> -
                <a href="#" class="text-blue-600 hover:underline">Proposer une correction</a>
            </p>
            <div class="mt-6">
                <p class="text-lg text-gray-700 leading-relaxed">
                    {{ $blog->body }}
                </p>
            </div>

            <div>
                <livewire:blog.heart :blog="$blog" />
            </div>

                <div class="mt-4">
                    <livewire:comments.create :blogId="$blog->id" />
                </div>
            <div>
                <livewire:comments.index :blogId="$blog->id" />
            </div>
        </div>
    </x-card>

</div>


