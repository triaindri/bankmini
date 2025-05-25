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

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @if ($errors->any())
                <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                    <ul class="list-disc pl-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf

                <!-- NIS -->
                <div class="mb-4">
                    <label for="nis" class="block font-medium text-gray-700">NIS</label>
                    <input type="text" name="nis" id="nis" value="{{ old('nis') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>

                <!-- Nama -->
                <div class="mb-4">
                    <label for="nama" class="block font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>

                <!-- Kelas -->
                <div class="mb-4">
                    <label for="kelas" class="block font-medium text-gray-700">Kelas</label>
                    <input type="text" name="kelas" id="kelas" value="{{ old('kelas') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamat" class="block font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('alamat') }}</textarea>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-4">
                    <label for="jeniskelamin" class="block font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jeniskelamin" id="jeniskelamin" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="perempuan" {{ old('jeniskelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        <option value="laki-laki" {{ old('jeniskelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    </select>
                </div>

                <!-- Tombol Simpan -->
                <div class="mt-6">
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Simpan
                    </button>
                    <a href="{{ route('siswa.index') }}"
                        class="ml-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
