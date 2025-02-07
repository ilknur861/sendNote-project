<?php

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {

    public Blog $blog;

    public function with()
    {
        $user= auth()->user()->name ;
        return [
            'notesSentCount' => Auth::user()
                ->notes()
                ->where('send_date', '<', now())
                ->where('is_published', true)
                ->count(),

            'notesLovedCount' => Auth::user()->notes->sum('heart_count'),
            'blogs' => Blog::all()
                ->where('author',$user)
                ->count(),
            'blogSend'=>Blog::all()
                ->where('author',$user)
                ->where('posted',true)
                ->count(),

        ];
    }
}; ?>

<div>
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-2">
        <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div>
                    <p class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Notes Sent</p>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-3xl font-bold leading-9 text-gray-900 dark:text-gray-100">{{ $notesSentCount }}</p>
            </div>
        </div>
        <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div>
                    <p class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Notes Loved</p>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-3xl font-bold leading-9 text-gray-900 dark:text-gray-100">{{ $notesLovedCount }}</p>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div>
                    <p class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Post Sent</p>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-3xl font-bold leading-9 text-gray-900 dark:text-gray-100">{{ $blogs }}</p>
            </div>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div>
                    <p class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Blogs posted</p>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-3xl font-bold leading-9 text-gray-900 dark:text-gray-100">{{ $blogSend }}</p>
            </div>
        </div>

    </div>
</div>
