<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Create notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <x-button icon="arrow-left" class="mb-12" href="{{ route('notes.index') }}">
                All notes
            </x-button>
            <livewire:notes.create-note />
        </div>
    </div>

</x-app-layout>
