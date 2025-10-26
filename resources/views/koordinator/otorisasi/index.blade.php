<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Otorisasi Penarikan Saldo
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded shadow">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <table class="table-auto w-full bg-white border dark:bg-gray-400 border-gray-200 rounded-lg shadow-md text-sm">
            <thead class="bg-blue-800 dark:bg-gray-700 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-center">Nama Siswa</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Jenis</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Jumlah</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Tanggal</th>
                    <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiPending as $trx)
                    <tr class="border-b">
                        <td class="px-4 py-2 border text-center">{{ $trx->tabungan->siswa->nama }}</td>
                        <td class="px-4 py-2 border text-center">{{ $trx->keterangan }}</td>
                        <td class="px-4 py-2 border text-center">Rp{{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border text-center">{{ $trx->tanggal->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 border text-center">
                            <form method="POST" action="{{ route('otorisasi.update', $trx->id) }}" class="inline">
                                @csrf
                                <input type="hidden" name="aksi" value="setujui">
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">Setujui</button>
                            </form>
                            <form method="POST" action="{{ route('otorisasi.update', $trx->id) }}" class="inline">
                                @csrf
                                <input type="hidden" name="aksi" value="tolak">
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Tolak</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-3">Tidak ada transaksi menunggu otorisasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
