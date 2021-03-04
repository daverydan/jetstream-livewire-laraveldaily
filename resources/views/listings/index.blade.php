<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('listings.create') }}" class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">{{ __('Add new listing') }}</a>

            <div class="mb-4">
                <form method="GET" action="">
                    <input type="text" name="title" placeholder="Title" value="{{ request('title') }}" />
                    <select name="category">
                        <option value="">-- choose category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                    @if (request('category') == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select name="size">
                        <option value="">-- choose size --</option>
                        @foreach ($sizes as $size)
                            <option value="{{ $size->id }}"
                                    @if (request('size') == $size->id) selected @endif>{{ $size->name }}</option>
                        @endforeach
                    </select>
                    <select name="color">
                        <option value="">-- choose color --</option>
                        @foreach ($colors as $color)
                            <option value="{{ $color->id }}"
                                    @if (request('color') == $color->id) selected @endif>{{ $color->name }}</option>
                        @endforeach
                    </select>
                    <select name="city">
                        <option value="">-- choose city --</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}"
                                    @if (request('city') == $city->id) selected @endif>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    {{-- @livewire('listing-saved-checkbox') --}}
                    <span class="mx-2">
                        <input type="checkbox" name="saved"> Saved (0)
                    </span>
                    <button type="submit" class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Search</button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categories</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sizes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Colors</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">City</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="relative px-6 py-3" colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($listings as $listing)
                            <tr>
                                <td class="px-6 py-4">
                                    @if ($listing->getFirstMediaUrl('listings', 'thumb'))
                                        <img src="{{ $listing->getFirstMediaUrl('listings', 'thumb') }}" alt="{{ $listing->title }}">
                                    @endif
                                </td>
                                <td class="px-6 py-4">{{ $listing->title }}</td>
                                <td class="px-6 py-4">{{ $listing->description }}</td>
                                <td class="px-6 py-4">
                                    @foreach ($listing->categories as $category)
                                        {{ $category->name }}
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    @foreach ($listing->sizes as $size)
                                        {{ $size->name }}
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    @foreach ($listing->colors as $color)
                                        {{ $color->name }}
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    {{ $listing->user->city->name ?? '' }}
                                </td>
                                <td class="px-6 py-4">${{ $listing->price }}</td>
                                <td class="px-6 py-4">
                                    @if ($listing->user_id != auth()->id())
                                        <a href="" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Save</a>
                                    @endif
                                    @can('update', $listing)
                                        <a href="{{ route('listings.edit', $listing) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Edit</a>
                                    @endcan
                                </td>
                                <td class="px-6 py-4">
                                    @can('delete', $listing)
                                        <form method="POST" action="{{ route('listings.destroy', $listing) }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-jet-danger-button onclick="return confirm('Are you sure you want to delete?')" type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Delete</x-jet-danger-button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="m-4">
                    {{ $listings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
