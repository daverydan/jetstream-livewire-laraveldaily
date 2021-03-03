<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Listing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-jet-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"/>
                @error('title')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="description" value="{{ __('Address') }}" />
                <textarea id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="price" value="{{ __('Price') }}" />
                <x-jet-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')"/>
                @error('price')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="photo1" value="{{ __('Photo 1') }}" />
                <input type="file" name="photo1" id="photo1">
                @error('photo1')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="photo2" value="{{ __('Photo 2') }}" />
                <input type="file" name="photo2" id="photo2">
                @error('photo2')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="photo3" value="{{ __('Photo 3') }}" />
                <input type="file" name="photo3" id="photo3">
                @error('photo3')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="categories" value="{{ __('Categories') }}" />
                @foreach ($categories as $category)
                    <input type="checkbox" name="categories[]" id="categories" value="{{ $category->id }}">
                    {{ $category->name }}
                    <br>
                @endforeach
            </div>

            <div class="mt-4">
                <x-jet-label for="sizes" value="{{ __('Sizes') }}" />
                @foreach ($sizes as $size)
                    <input type="checkbox" name="sizes[]" id="sizes" value="{{ $size->id }}">
                    {{ $size->name }}
                    <br>
                @endforeach
            </div>

            <div class="mt-4">
                <x-jet-label for="colors" value="{{ __('Colors') }}" />
                @foreach ($colors as $color)
                    <input type="checkbox" name="colors[]" id="colors" value="{{ $color->id }}">
                    {{ $color->name }}
                    <br>
                @endforeach
            </div>

            <div class="flex items-center mt-6">
                <x-jet-button>
                    {{ __('Save') }}
                </x-jet-button>
            </div>
        </form>
        </div>
    </div>
</x-app-layout>
