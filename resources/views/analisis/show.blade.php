<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl px-1 py-2 text-white leading-tight">
            Analisis Perilaku Menabung — {{ $siswa->nama }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-semibold mb-2">Data Ekonomi Keluarga</h3>
            <p>Pendapatan Orang Tua: Rp {{ number_format($siswa->pendapatan_orang_tua ?? 0, 0, ',', '.') }}</p>
            <p>Jumlah Tanggungan: {{ $siswa->jumlah_tanggungan ?? '-' }} orang</p>
            @if (is_null($siswa->pendapatan_orang_tua) || is_null($siswa->jumlah_tanggungan))
                <p class="text-red-600 text-sm mt-2">
                    Data belum lengkap. Lengkapi dulu di halaman edit data siswa sebelum menjalankan analisis.
                </p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-semibold mb-4">Jalankan Analisis Untuk Siswa Ini</h3>
            <form method="POST" action="{{ route('analisis.generate') }}" class="flex flex-wrap items-end gap-4">
                @csrf
                <input type="hidden" name="siswa_id" value="{{ $siswa->id }}">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Periode Awal</label>
                    <input type="date" name="periode_awal" required class="mt-1 border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Periode Akhir</label>
                    <input type="date" name="periode_akhir" required class="mt-1 border-gray-300 rounded-md shadow-sm">
                </div>
                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md">
                    Jalankan
                </button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Frekuensi</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Setoran</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skor</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($riwayat as $r)
                        <tr>
                            <td class="px-4 py-3 text-sm">{{ $r->periode_awal->format('d/m/Y') }} - {{ $r->periode_akhir->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ $r->frekuensi_menabung }}x</td>
                            <td class="px-4 py-3">Rp {{ number_format($r->jumlah_setoran, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ $r->skor }}</td>
                            <td class="px-4 py-3">
                                <span @class([
                                    'px-2 py-1 rounded-full text-xs font-semibold',
                                    'bg-red-100 text-red-700' => $r->kategori === 'Kurang',
                                    'bg-yellow-100 text-yellow-700' => $r->kategori === 'Cukup',
                                    'bg-green-100 text-green-700' => $r->kategori === 'Baik',
                                ])>{{ $r->kategori }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada riwayat analisis.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <a href="{{ route('analisis.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke daftar</a>
        </div>
    </div>
</x-app-layout>