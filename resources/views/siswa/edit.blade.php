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
            <h1 class="text-xl font-bold mb-4">Edit Data Siswa</h1>

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

                <div class="mb-4">
                    <label class="block font-semibold">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" class="w-full border rounded px-3 py-2" required>
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
                    <x-primary-button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</x-primary-button>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>