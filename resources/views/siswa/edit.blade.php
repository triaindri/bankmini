<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('siswa.index') }}" class="text-white hover:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl text-white dark:text-gray-300 font-semibold">Ubah Data Siswa</h1>
        </div>
    </x-slot>

    <main class="max-w-3xl mx-auto py-6">
        <div class="bg-white p-6 rounded shadow">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-semibold">NISN</label>
                    <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" class="w-full border rounded px-3 py-2 bg-gray-100" readonly>
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
                    <label class="block font-semibold">Kelas</label>
                    <select name="kelas" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas }}" {{ old('kelas', $siswa->kelas) == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $siswa->email) }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">No. Telepon</label>
                    <input type="text" name="telepon" value="{{ old('telepon', $siswa->telepon) }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}" class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Alamat</label>
                    <textarea name="alamat" class="w-full border rounded px-3 py-2" rows="3" required>{{ old('alamat', $siswa->alamat) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold">Jenis Kelamin</label>
                    <select name="jeniskelamin" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih --</option>
                        <option value="laki-laki" {{ old('jeniskelamin', $siswa->jeniskelamin) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ old('jeniskelamin', $siswa->jeniskelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('siswa.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                    <x-primary-button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Simpan
                    </x-primary-button>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>
