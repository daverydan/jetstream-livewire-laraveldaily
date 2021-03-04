<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send a Message') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('messages.store') }}">
                <input type="hidden" name="listing_id" value="{{ request('listing_id') }}">
                @csrf

                <div class="mt-4">
                    <x-jet-label for="message" value="{{ __('Message') }}" />
                    <textarea id="message" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="message" rows="10" required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex items-center mt-6">
                    <x-jet-button>
                        {{ __('Send message') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
