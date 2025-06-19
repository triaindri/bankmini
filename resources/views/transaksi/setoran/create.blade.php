<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('setoran.index') }}" class="text-white hover:text-blue-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl text-white dark:text-gray-300 font-semibold">Tambah Transaksi Setoran</h1>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto py-6">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="text-sm list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('setoran.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label for="nis" class="block font-medium">NISN</label>
                <input type="text" name="nis" id="nis" required value="{{ old('nis') }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" autocomplete="off" />
                @error('nis') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="nama" class="block font-medium">Nama</label>
                <input type="text" name="nama" id="nama" readonly
                    class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-600" />
            </div>

            <div>
                <label for="kelas" class="block font-medium">Kelas</label>
                <input type="text" name="kelas" id="kelas" readonly
                    class="w-full border rounded px-3 py-2 bg-gray-100 text-gray-600" />
            </div>

            <div>
                <label for="jumlah" class="block font-medium">Nominal Setoran</label>
                <input type="number" name="jumlah" id="jumlah" required min="1000" step="1000"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
                @error('jumlah') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="tanggal" class="block font-medium">Tanggal Setor</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
                @error('tanggal') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan Setoran
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('nis').addEventListener('change', function () {
            const nis = this.value.trim();

            if(nis.length === 0) {
                document.getElementById('nama').value = '';
                document.getElementById('kelas').value = '';
                return;
            }

            fetch("{{ route('setoran.getSiswaByNis') }}?nis=" + nis)
                .then(response => {
                    if(!response.ok) throw new Error('NIS tidak ditemukan');
                    return response.json();
                })
                .then(data => {
                    document.getElementById('nama').value = data.nama;
                    document.getElementById('kelas').value = data.kelas;
                })
                .catch(() => {
                    alert('NIS tidak ditemukan');
                    document.getElementById('nama').value = '';
                    document.getElementById('kelas').value = '';
                });
        });
    </script>
    @endpush
</x-app-layout>
