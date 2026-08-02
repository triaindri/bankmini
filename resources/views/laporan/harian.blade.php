<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl px-1 py-2 text-white leading-tight">Laporan Kas</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('laporan.harian.index') }}" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                    <input type="date" name="awal" value="{{ $awal->format('Y-m-d') }}"
                        class="mt-1 border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                    <input type="date" name="akhir" value="{{ $akhir->format('Y-m-d') }}"
                        class="mt-1 border-gray-300 rounded-md shadow-sm">
                </div>
                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md">
                    Tampilkan
                </button>
                <a href="{{ route('laporan.harian.export', request()->query()) }}"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                    Export CSV
                </a>
            </form>
            <p class="text-sm text-gray-500 mt-2">
                Menampilkan periode {{ $awal->translatedFormat('d F Y') }} — {{ $akhir->translatedFormat('d F Y') }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-sm font-semibold text-gray-500">Total Setoran</h3>
                <p class="text-2xl font-bold text-green-600 mt-1">
                    Rp {{ number_format($rekap->total_setor ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mt-1">{{ $rekap->jumlah_transaksi_setor ?? 0 }} transaksi</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-sm font-semibold text-gray-500">Total Penarikan</h3>
                <p class="text-2xl font-bold text-red-600 mt-1">
                    Rp {{ number_format($rekap->total_tarik ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mt-1">{{ $rekap->jumlah_transaksi_tarik ?? 0 }} transaksi</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 text-center">
            <h3 class="text-sm font-semibold text-gray-500">Selisih Kas (Setoran − Penarikan)</h3>
            <p class="text-3xl font-bold text-blue-700 mt-1">
                Rp {{ number_format(($rekap->total_setor ?? 0) - ($rekap->total_tarik ?? 0), 0, ',', '.') }}
            </p>
        </div>
    </div>
</x-app-layout>