<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <livewire:notes.show-notes lazy />

                </div>

        </div>
    </div>

</x-app-layout>
