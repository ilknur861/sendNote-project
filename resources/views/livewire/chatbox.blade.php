<?php

use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {

    #[Validate('required|string')]
    public string $question = '';
    public string $userId = '';
    #[Session(key: 'message')]
    public array $messages = []; // Array to store conversation

    public function save()
    {
        $this->validate();

        $this->userId = auth()->id(); // Retrieve authenticated user's ID

        // Add the user's message to the conversation
        $this->messages[] = [
            'sender' => 'user',
            'message' => $this->question,
        ];

        try {
            // Call Python API
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->post('http://127.0.0.1:8000/chat', [
                'user_id' => $this->userId,
                'question' => $this->question,
            ]);

            if ($response->successful()) {
                // Add AI's response to the conversation
                $this->messages[] = [
                    'sender' => 'ai',
                    'message' => $response->json()['response'] ?? 'No response',
                ];
                $this->question = ''; // Clear the input
            } else {
                $this->reset('question');
                $this->messages[] = [
                    'sender' => 'ai',
                    'message' => $response->json()['detail'],
                ];
            }
        } catch (\Exception $e) {
            $this->reset('question');
            $this->messages[] = [
                'sender' => 'ai',
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }

        session(['messages' => $this->messages]);
    }

    public function clearSession()
    {
        session()->forget('messages'); // Clear the session messages
        $this->messages = []; // Reset the messages array
    }

};
?>


<div class="flex items-center justify-center h-screen">
    <div class="flex flex-col w-full h-[80vh] shadow-md bg-gray-500 rounded-md">
        <div class="flex-grow p-4 overflow-y-auto">
            @if (empty($messages))
                <!-- Display welcome message -->
                <div class="flex items-center justify-center h-full text-black">
                    Welcome to your assistant! How can I help you?
                </div>
            @else
                <!-- Display messages -->
                @foreach ($messages as $index => $message)
                    <!-- Display the second message from the session -->

                    @if ($message['sender'] === 'ai')
                        <!-- AI's message -->
                        <div class="flex items-start space-x-2 mb-4" key="{{ $index }}">
                            <div
                                class="w-8 h-8 bg-gray-400 text-white flex items-center justify-center rounded-full font-bold">
                                AI
                            </div>
                            <div class="bg-gray-200 text-gray-900 px-4 py-2 rounded-lg max-w-xs">
                                {{ $message['message'] }}
                            </div>
                        </div>
                    @else
                        <!-- User's message -->
                        <div class="flex items-end justify-end space-x-2 mb-4" key="{{ $index }}">
                            <div class="bg-blue-500 text-white px-4 py-2 rounded-lg max-w-xs">
                                {{ $message['message'] }}
                            </div>
                            <div
                                class="w-8 h-8 bg-blue-400 text-white flex items-center justify-center rounded-full font-bold">
                                U
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <!-- Input area -->
        <form wire:submit.prevent="save">
            <div class="flex items-center p-3">
                <input
                    type="text"
                    wire:model.defer="question"
                    placeholder="Type a message"
                    class="flex-grow border border-gray-300 rounded-full px-4 py-2 outline-none text-black"
                />
                <button
                    type="submit"
                    class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-50"
                >
                    Send
                </button>
                <div wire:loading class="ml-2 text-white">
                    Sending...
                </div>
            </div>
        </form>

        <div class="p-3 flex justify-end">
            <button
                wire:click="clearSession"
                class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600"
            >
                Clear Conversation
            </button>
        </div>

    </div>
</div>

