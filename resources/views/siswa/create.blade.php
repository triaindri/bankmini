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
                <div class="mb-4">
                    <label for="nis" class="block font-medium text-gray-700">NISN</label>
                    <input type="text" name="nis" id="nis" value="{{ old('nis') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>
                <div class="mb-4">
                    <label for="nama" class="block font-medium text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>
                @php
                    $kelasList = [
                        'X AKUL 1', 'X AKUL 2', 'X AKUL 3',
                        'X BDP 1', 'X BDP 2',
                        'X AP 1', 'X AP 2', 'X AP 3',
                        'X TKJ 1', 'X TKJ 2',
                        'X TEIND 1', 'X TEIND 2', 
                        'X TKR 1', 'X TKR 2', 'X TKR 3',
                        'XI AKUL 1', 'XI AKUL 2', 'XI AKUL 3',
                        'XI BDP 1', 'XI BDP 2', 
                        'XI AP 1', 'XI AP 2', 'XI AP 3',
                        'XI TKJ 1', 'XI TKJ 2', 
                        'XI TEIND 1', 'XI TEIND 2', 
                        'XI TKR 1', 'XI TKR 2', 'XI TKR 3',
                        'XII AKUL 1', 'XII AKUL 2', 'XII AKUL 3',
                        'XII BDP 1', 'XII BDP 2', 
                        'XII AP 1', 'XII AP 2', 'XII AP 3',
                        'XII TKJ 1', 'XII TKJ 2', 
                        'XII TEIND 1', 'XII TEIND 2', 
                        'XII TKR 1', 'XII TKR 2', 'XII TKR 3',
                    ];
                @endphp

                <div class="mb-4">
                    <label class="block font-medium text-gray-700">Kelas</label>
                    <select name="kelas" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas }}" {{ old('kelas') == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                 <div class="mb-4">
                    <label for="email" class="block font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>
                <div class="mb-4">
                    <label for="telepon" class="block font-medium text-gray-700">No. Telepon</label>
                    <input type="tel" name="telepon" id="telepon" value="{{ old('telepon') }}"
                        maxlength="13" pattern="[0-9]{10,13}" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300"
                        placeholder="Contoh: 081234567890">
                    <small class="text-gray-500">Maksimal 13 digit angka</small>
                </div>
                <div class="mb-4">
                    <label for="tempat_lahir" class="block font-medium text-gray-700">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>
                <div class="mb-4">
                    <label for="tanggal_lahir" class="block font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ old('alamat') }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="jeniskelamin" class="block font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jeniskelamin" id="jeniskelamin" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="perempuan" {{ old('jeniskelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        <option value="laki-laki" {{ old('jeniskelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    </select>
                </div>
                <div class="mt-6">
                    <x-primary-button type="submit"
                        class="ms-3">
                        Simpan
                    </x-primary-button>
                    <a href="{{ route('siswa.index') }}"
                        class="ml-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
