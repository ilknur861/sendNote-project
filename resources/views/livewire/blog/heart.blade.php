<?php

use App\Models\Blog;
use App\Models\BlogLike;
use Livewire\Volt\Component;

new class extends Component {

    public Blog $blog;
    public $likes;
    public $showAlert = false;

    public function mount(Blog $blog)
    {
        $this->blog = $blog;
        $this->likes = $blog->likes ?? 0;
    }

    public function increaseHeartCount()
    {
        $userHasLiked = BlogLike::where('blog_id', $this->blog->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($userHasLiked) {
            session()->flash('alert', [
                'message' => 'You have already liked this post',
                'status' => 'updated',
                'type' => 'warning',
                'class'=>'alert-danger'
            ]);
            $this->showAlert = true;
            return;
        }

        BlogLike::create([
            'blog_id' => $this->blog->id,
            'user_id' => auth()->id(),
        ]);

        $this->blog->increment('likes');
        $this->likes = $this->blog->likes;
    }

}; ?>

<div class="mt-3">
    <div
        x-data="{ showAlert: @entangle('showAlert') }"
        x-init="() => { $watch('showAlert', value => { if (value) { setTimeout(() => showAlert = false, 3000); } }); }"
        x-show="showAlert"
        class="fixed top-0 right-0 mt-4 mr-4 py-12 justify-end z-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                @if(session()->has('alert'))
                    <!-- Display Alert based on session flash data -->
                    <div class="alert flex {{ session('alert.class') }}">
                        @if(session('alert.type') === 'positive')
                            <x-alert
                                title="{{ session('alert.message') }}"
                                positive
                                class="{{ session('alert.class') }}"
                                rounded="lg"
                                solid
                            />
                        @elseif(session('alert.type') === 'error')
                            <x-alert
                                title="{{ session('alert.message') }}"
                                error
                                class="{{ session('alert.class') }}"
                                rounded="lg"
                                solid
                            />
                        @elseif(session('alert.type') === 'warning')
                            <x-alert
                                title="{{ session('alert.message') }}"
                                warning
                                class="{{ session('alert.class') }}"
                                rounded="lg"
                                solid
                            />
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-button xs wire:click="increaseHeartCount" rose icon="heart" spinner>
        {{ $likes }}
    </x-button>
</div>

