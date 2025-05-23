<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('siswa.index') }}" class="text-white hover:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl text-white dark:text-gray-300 font-semibold">Tambah Siswa</h1>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
            <form method="POST" action="{{ route('siswa.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="nis" class="block text-gray-700">NIS</label>
                    <input type="text" id="nis" name="nis" value="{{ old('nis') }}"
                           class="w-full px-3 py-2 border rounded" required>
                    @error('nis') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="nama" class="block text-gray-700">Nama</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                           class="w-full px-3 py-2 border rounded" required>
                    @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('siswa.index') }}" class="px-4 py-2 bg-gray-300 rounded mr-2">Batal</a>
                    <button type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
