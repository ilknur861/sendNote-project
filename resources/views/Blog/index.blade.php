<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Blogs') }}
        </h2>
    </x-slot>

    <div class="items-center flex justify-center">
        <livewire:blog.index />
    </div>

</x-app-layout>
