<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Create Button & Session Alerts --}}
           <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg mb-6">
    <div class="p-6 text-xl text-gray-900 dark:text-gray-100">
        <div class="flex items-center justify-between">
            <!-- Tombol Create Category yang jelas terlihat -->
            <a href="{{ route('category.create') }}"
               class="bg-blue-600 text-black text-sm font-semibold py-2 px-6 rounded-md hover:bg-blue-700 transition">
                Create
            </a>

            @if (session('success'))
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 5000)" class="text-sm text-green-600 dark:text-green-400">
                    {{ session('success') }}
                </p>
            @endif
        </div>
    </div>
</div>


            {{-- Category Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow ring-1 ring-gray-200 dark:ring-gray-700 sm:rounded-lg">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Todo Count</th>
                                <th class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="border-b dark:border-gray-600">
                                    <td class="px-6 py-4 font-semibold text-base text-gray-900 dark:text-gray-100">
                                        <a href="{{ route('category.edit', $category) }}" class="hover:underline">
                                            {{ $category->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $category->todos_count }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('category.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 text-sm hover:underline hover:text-red-800">
                                                🗑 Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No categories available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
