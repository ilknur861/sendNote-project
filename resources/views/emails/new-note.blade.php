<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You Have a New Note</title>
    <style>
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans leading-relaxed">

<div class="flex justify-center mt-8">
        <x-application-logo class="w-12 h-12 fill-current text-gray-500" />
</div>

<div class="max-w-3xl mx-auto bg-white p-8 shadow-lg rounded-lg mt-5">
    <!-- Header Section -->
    <div class="text-center mb-6">
        <h1 class="text-xl font-semibold text-gray-900">You have a new note from {{ $noteUserName }}</h1>
    </div>

    <!-- Body Section -->
    <div class="mb-6">
        <p class="text-lg text-gray-700 leading-relaxed">{{ $noteContent }}</p>
    </div>

    <!-- Button Section -->
    <div class="text-center">
        <a href="{{ $url }}"
           class="block bg-green-500 hover:bg-green-600 text-white text-center font-bold py-2 px-4 rounded-lg mt-6"
           style="text-decoration: none;">
            view the note
        </a>
    </div>
    <p class="leading-normal mt-4">
        Thanks,<br>
        Send Note App ,
    </p>
</div>

<!-- Footer Section -->
<div class="bg-gray-100 text-gray-500 text-sm text-center py-4 mt-6">
    &copy; {{ date('Y') }} Send Notes App. All rights reserved.
</div>

</body>
</html>
