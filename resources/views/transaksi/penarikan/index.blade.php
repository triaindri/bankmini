<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="text-xl font-bold text-white">Penarikan Tabungan</h2>
            <div class="mt-4 sm:mt-0 flex items-center space-x-2">
                <form method="GET" action="{{ route('penarikan.index') }}" class="relative flex items-center gap-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                 fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 
                                    1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 
                                    6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </div>
                        <input type="text" name="q" id="search-input" value="{{ request('q') }}"
                               placeholder="Cari nama / NIS"
                               class="pl-10 pr-4 py-2 border rounded text-sm focus:outline-none focus:ring w-64"/>
                    </div>
                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 text-sm">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-3 max-w-6xl mx-auto">
        <div class="bg-white p-6 rounded shadow">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 border border-green-300 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-700 border border-red-300 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 border border-red-300 px-4 py-2 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Penarikan --}}
            <form id="formPenarikan" action="{{ route('penarikan.store') }}" method="POST" class="mb-6">
                @csrf
                <input type="hidden" name="siswa_id" id="siswa_id" value="{{ old('siswa_id') }}">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700">NISN</label>
                        <input type="text" id="nis" class="mt-1 block w-full border rounded px-3 py-2" readonly>
                    </div>
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="nama" class="mt-1 block w-full border rounded px-3 py-2" readonly>
                    </div>
                    <div>
                        <label for="saldo" class="block text-sm font-medium text-gray-700">Saldo</label>
                        <input type="text" id="saldo" class="mt-1 block w-full border rounded px-3 py-2" readonly>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-3 gap-4">
                    <div class="col-span-1">
                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Penarikan</label>
                        <input type="number" name="jumlah" id="jumlah" min="500" step="500"
                               value="{{ old('jumlah') }}"
                               class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                               required>
                    </div>
                    <div class="col-span-1">
                        <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis Penarikan</label>
                        <select name="jenis" id="jenis" required
                                class="mt-1 block w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                            <option value="">-- Pilih Jenis Penarikan --</option>
                            <option value="Pembelian ATK" {{ old('jenis') == 'Pembelian ATK' ? 'selected' : '' }}>Pembelian ATK</option>
                            <option value="Study Tour" {{ old('jenis') == 'Study Tour' ? 'selected' : '' }}>Study Tour</option>
                            <option value="Kenaikan Kelas" {{ old('jenis') == 'Kenaikan Kelas' ? 'selected' : '' }}>Kenaikan Kelas</option>
                        </select>
                    </div>
                    <div></div>
                </div>
                <div class="mt-4">
                    <button type="submit" id="tarikBtn"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
                            disabled>
                        Tarik Saldo
                    </button>
                </div>
            </form>

            {{-- Tabel Siswa --}}
            <table class="table-auto w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-blue-700 text-white">
                <tr>
                    <th class="border px-4 py-2 text-center">No</th>
                    <th class="border px-4 py-2 text-center">NISN</th>
                    <th class="border px-4 py-2 text-center">Nama</th>
                    <th class="border px-4 py-2 text-center">Saldo</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($siswa as $index => $item)
                    <tr class="hover:bg-gray-100 cursor-pointer"
                        data-id="{{ $item->id }}"
                        data-nis="{{ $item->nis }}"
                        data-nama="{{ $item->nama }}"
                        data-saldo="{{ optional($item->tabungan)->saldo ?? 0 }}">
                        <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2 text-center">{{ $item->nis }}</td>
                        <td class="border px-4 py-2">{{ $item->nama }}</td>
                        <td class="border px-4 py-2 text-center">
                            Rp{{ number_format(optional($item->tabungan)->saldo ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            const rows = document.querySelectorAll('tbody tr');
            const siswaId = document.getElementById('siswa_id');
            const nisInput = document.getElementById('nis');
            const namaInput = document.getElementById('nama');
            const saldoInput = document.getElementById('saldo');
            const tarikBtn = document.getElementById('tarikBtn');

            // Event klik baris
            rows.forEach(row => {
                row.addEventListener('click', () => {
                    siswaId.value = row.dataset.id;
                    nisInput.value = row.dataset.nis;
                    namaInput.value = row.dataset.nama;
                    saldoInput.value = 'Rp ' + Number(row.dataset.saldo).toLocaleString('id-ID');
                    tarikBtn.disabled = false;

                    // Highlight baris yang dipilih
                    rows.forEach(r => r.classList.remove('bg-blue-100'));
                    row.classList.add('bg-blue-100');
                });
            });

            // Restore input lama jika validasi gagal
            document.addEventListener('DOMContentLoaded', function () {
                const oldSiswaId = "{{ old('siswa_id') }}";
                if (oldSiswaId) {
                    const selectedRow = Array.from(rows).find(row => row.dataset.id === oldSiswaId);
                    if (selectedRow) {
                        selectedRow.click();
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
