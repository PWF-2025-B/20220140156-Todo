<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Create Todo Page') }}
                </div>
            </div>

            {{-- Form --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('todo.store') }}">
                        @csrf

                        {{-- Title --}}
                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="block w-full mt-1" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        {{-- Category --}}
                        <div class="mb-6">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <x-select id="category_id" name="category_id" class="block w-full mt-1">
                                <option value="">Empty</option>
                                @foreach ($categories as $category)
                                   <option value="{{ $category->id }}">{{ $category->name }}</option>

                                @endforeach
                            </x-select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('todo.index') }}"
                               class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest
                                      text-gray-700 uppercase bg-white border border-gray-300 rounded-md shadow-sm
                                      dark:bg-gray-800 dark:border-gray-500 dark:text-gray-300
                                      hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none
                                      focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                      dark:focus:ring-offset-gray-800 disabled:opacity-25">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
