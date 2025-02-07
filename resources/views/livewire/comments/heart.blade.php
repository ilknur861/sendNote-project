<?php

use App\Models\Blog;
use Livewire\Volt\Component;

new class extends Component {
    //
    public Blog $blog;
    public $likes;

    public function mount(Blog $blog)
    {
        $this->blog = $blog;
        $this->likes = $blog->likes;
    }

    public function increaseHeartCount()
    {
        $this->blog->likes++;
        $this->blog->save();
        $this->likes = $this->blog->likes;
    }

}; ?>

<div>
    <x-button xs wire:click="increaseHeartCount" rose icon="heart" spinner>{{ $likes }}</x-button>
</div>
