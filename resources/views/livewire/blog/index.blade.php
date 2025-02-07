<?php

use App\Models\Blog;
use Livewire\Volt\Component;

new class extends Component {
    //

    public function with()
    {
        return [
            'blogs'=> Blog::orderBy('created_at', 'desc')
                ->get()
        ] ;

    }

}; ?>

<div class="space-y-4 mt-4">
    <div class="space-y-4">
        @if($blogs->isNotEmpty())
            @foreach($blogs as $blog)
                <x-card wire:key="{{ $blog->id }}" rounded="3xl">
                    <div class="shadow-lg rounded-lg max-w-md mx-auto p-6 mb-4">
                        <!-- Image Section -->
                        <div class="relative">
                            <img src="{{ asset('storage/' . $blog->photo) }}" alt="Blog Photo" class="w-full h-48 object-cover rounded-t-lg">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                <h1 class="text-white font-bold text-2xl">
                                    <a href="{{ route('blogs.show',$blog->id) }}" wire:navigate class="hover:bg-gray-700">
                                        See more ...
                                    </a>
                                </h1>
                            </div>
                        </div>

                        <!-- Text Content Section -->
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($blog->created_at)->format('d-M-Y') }}</p>
                                <p class="text-gray-500 text-sm">Category: {{ $blog->categories }}</p>
                            </div>

                            <h2 class="text-gray-900 text-xl font-bold mb-3">{{ $blog->title }}</h2>
                            <p class="text-gray-700 text-sm mb-4 break-words">
                                {{ Str::limit($blog->body, 150) }} ...
                            </p>
                            <p class="text-gray-600 text-sm italic">Auteur: {{ $blog->author }}</p>
                        </div>
                    </div>
                </x-card>
            @endforeach
        @else
            <div>
                <p class="text-xl text-gray-500">
                    There is not yet a blog
                </p>
            </div>
        @endif

    </div>
</div>

