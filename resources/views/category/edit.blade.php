<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Edit Category Page") }}
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('category.update', $category->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Input Name --}}
                        <div class="mb-6">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input 
                                id="name" 
                                name="name" 
                                type="text" 
                                class="mt-1 block w-full" 
                                :value="old('name', $category->name)" 
                                required 
                                autofocus 
                                autocomplete="name" 
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        {{-- Buttons --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                            <a href="{{ route('category.index') }}"
                               class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest
                                      text-gray-700 uppercase transition duration-150 ease-in-out
                                      bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-800
                                      dark:border-gray-500 dark:text-gray-300 hover:bg-gray-50
                                      dark:hover:bg-gray-700 focus:outline-none focus:ring-2
                                      focus:ring-indigo-500 focus:ring-offset-2
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
