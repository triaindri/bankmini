<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">Setoran Tabungan</h2>
            <a href="{{ route('setoran.create') }}"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                + Tambah Transaksi Setoran
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6">
        <div class="bg-white p-6 rounded shadow">
            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table-auto w-full border border-gray-200 rounded shadow">
                <thead class="bg-blue-700 text-white">
                    <tr>
                        <th class="border px-4 py-2 text-center">No</th>
                        <th class="border px-4 py-2 text-center">NIS</th>
                        <th class="border px-4 py-2 text-center">Nama</th>
                        <th class="border px-4 py-2 text-center">Kelas</th>
                        <th class="border px-4 py-2 text-center">Nominal Setoran</th>
                        <th class="border px-4 py-2 text-center">Tanggal Setor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($setorans as $i => $setoran)
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2 text-center">{{ $i + 1 }}</td>
                            <td class="border px-4 py-2 text-center">{{ $setoran->tabungan->siswa->nis }}</td>
                            <td class="border px-4 py-2">{{ $setoran->tabungan->siswa->nama }}</td>
                            <td class="border px-4 py-2 text-center">{{ $setoran->tabungan->siswa->kelas }}</td>
                            <td class="border px-4 py-2 text-right">Rp{{ number_format($setoran->jumlah, 0, ',', '.') }}</td>
                            <td class="border px-4 py-2 text-center">{{ \Carbon\Carbon::parse($setoran->tanggal)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
