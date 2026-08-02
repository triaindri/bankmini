<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-semibold text-xl px-1 py-2 text-white leading-tight">Laporan Bank Mini</h2>
            <a href="{{ route('laporan.export', request()->query()) }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm">
                Cetak PDF
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto sm:px-6 lg:px-8">

        {{-- Filter periode --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('laporan.index') }}" class="flex flex-wrap items-end gap-4">
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
            </form>
            <p class="text-sm text-gray-500 mt-2">
                Periode {{ $awal->translatedFormat('d F Y') }} — {{ $akhir->translatedFormat('d F Y') }}
            </p>
        </div>

        {{-- Bagian 1: Laporan Kas --}}
        <h3 class="font-semibold text-gray-800 mb-3">Rekap Kas</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-sm font-semibold text-gray-500">Total Setoran</h3>
                <p class="text-2xl font-bold text-green-600 mt-1">
                    Rp {{ number_format($rekapKas->total_setor ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mt-1">{{ $rekapKas->jumlah_transaksi_setor ?? 0 }} transaksi</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-sm font-semibold text-gray-500">Total Penarikan</h3>
                <p class="text-2xl font-bold text-red-600 mt-1">
                    Rp {{ number_format($rekapKas->total_tarik ?? 0, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400 mt-1">{{ $rekapKas->jumlah_transaksi_tarik ?? 0 }} transaksi</p>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center mb-8">
            <h3 class="text-sm font-semibold text-gray-500">Selisih Kas (Setoran − Penarikan)</h3>
            <p class="text-3xl font-bold text-blue-700 mt-1">
                Rp {{ number_format(($rekapKas->total_setor ?? 0) - ($rekapKas->total_tarik ?? 0), 0, ',', '.') }}
            </p>
        </div>

        {{-- Bagian 2: Data Siswa --}}
        <h3 class="font-semibold text-gray-800 mb-3">Data Siswa</h3>
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">NIS</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase">Kelas</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500 uppercase">Saldo</th>
                        <th class="px-4 py-3 text-center font-medium text-gray-500 uppercase">Kategori (Periode Ini)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($siswa as $s)
                        @php $analisis = $s->analisisPerilaku->first(); @endphp
                        <tr>
                            <td class="px-4 py-3">{{ $s->nis }}</td>
                            <td class="px-4 py-3">{{ $s->nama }}</td>
                            <td class="px-4 py-3">{{ $s->kelas }}</td>
                            <td class="px-4 py-3 text-right">
                                Rp {{ number_format(optional($s->tabungan)->saldo ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if ($analisis)
                                    <span @class([
                                        'px-2 py-1 rounded-full text-xs font-semibold',
                                        'bg-red-100 text-red-700' => $analisis->kategori === 'Kurang',
                                        'bg-yellow-100 text-yellow-700' => $analisis->kategori === 'Cukup',
                                        'bg-green-100 text-green-700' => $analisis->kategori === 'Baik',
                                    ])>{{ $analisis->kategori }}</span>
                                @else
                                    <span class="text-gray-400 text-xs">Belum dianalisis untuk periode ini</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada data siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>