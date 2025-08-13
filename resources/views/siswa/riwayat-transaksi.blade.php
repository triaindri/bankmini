<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-white">
            📜 Riwayat Transaksi
        </h2>
    </x-slot>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-100">
                        <th class="border px-4 py-2 text-left">Tanggal</th>
                        <th class="border px-4 py-2">Jenis</th>
                        <th class="border px-4 py-2">Jumlah</th>
                        <th class="border px-4 py-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $t)
                        <tr>
                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($t['tanggal'])->translatedFormat('d F Y') }}</td>
                            <td class="border px-4 py-2">{{ $t['jenis'] }}</td>
                            <td class="border px-4 py-2">
                                Rp {{ number_format($t['jumlah'], 0, ',', '.') }}
                            </td>
                            <td class="border px-4 py-2">{{ $t['keterangan'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-4 text-gray-500">Belum ada transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $transaksi->links() }}
        </div>
    </div>
</x-app-layout>
