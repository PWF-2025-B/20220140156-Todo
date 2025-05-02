<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Tampilkan hasil pencarian jika ada --}}
                    @if (request('search'))
                        <h2 class="pb-3 text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                            Search result for: {{ request('search') }}
                        </h2>
                    @endif

                    {{-- Notifikasi sukses --}}
                    @if (session('success'))
                        <p x-data="{ show: true }" x-show="show" x-transition
                           x-init="setTimeout(() => show = false, 5000)"
                           class="mb-3 text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </p>
                    @endif

                    {{-- Notifikasi error --}}
                    @if (session('danger'))
                        <p x-data="{ show: true }" x-show="show" x-transition
                           x-init="setTimeout(() => show = false, 5000)"
                           class="mb-3 text-sm text-red-600 dark:text-red-400">
                            {{ session('danger') }}
                        </p>
                    @endif

                    {{-- Form Pencarian --}}
                    <form method="GET" action="{{ route('user.index') }}" class="mb-4 flex items-center gap-2">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search user..."
                               class="w-full md:w-1/3 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:placeholder-gray-400"
                               autofocus>
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Cari
                        </button>
                    </form>

                    {{-- Tabel Data User --}}
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Id</th>
                                    <th scope="col" class="px-6 py-3">Nama</th>
                                    <th scope="col" class="hidden px-6 py-3 md:block">Email</th>
                                    <th scope="col" class="px-6 py-3">Todo</th>
                                    <th scope="col" class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $data)
                                    <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                        <td class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">
                                            {{ $data->id }}
                                        </td>
                                        <td class="px-6 py-4">{{ $data->name }}</td>
                                        <td class="hidden px-6 py-4 md:block">{{ $data->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <p>
                                                {{ $data->todos->count() }}
                                                <span>
                                                    <span class="text-green-600 dark:text-green-400">
                                                        ({{ $data->todos->where('is_done', true)->count() }}
                                                    </span>/
                                                    <span class="text-blue-600 dark:text-blue-400">
                                                        {{ $data->todos->where('is_done', false)->count() }})
                                                    </span>
                                                </span>
                                            </p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex space-x-3">
                                                {{-- Admin toggle --}}
                                                @if ($data->is_admin)
                                                    <form action="{{ route('user.removeadmin', $data) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                class="text-blue-600 dark:text-blue-400 whitespace-nowrap">
                                                            Remove Admin
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('user.makeadmin', $data) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                class="text-red-600 dark:text-red-400 whitespace-nowrap">
                                                            Make Admin
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Tombol hapus user --}}
                                                <form action="{{ route('user.destroy', $data) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="odd:bg-white odd:dark:bg-gray-800 even:bg-gray-50 even:dark:bg-gray-700">
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No data available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="px-6 py-5">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
