<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl px-1 py-2 text-white leading-tight">Analisis Perilaku Menabung</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form generate massal --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Jalankan Analisis (Semua Siswa)</h3>
            <form method="POST" action="{{ route('analisis.generate') }}" class="flex flex-wrap items-end gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Periode Awal</label>
                    <input type="date" name="periode_awal" required class="mt-1 border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Periode Akhir</label>
                    <input type="date" name="periode_akhir" required class="mt-1 border-gray-300 rounded-md shadow-sm">
                </div>
                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md">
                    Jalankan Analisis
                </button>
            </form>
            <p class="text-sm text-gray-500 mt-2">
                Siswa yang belum memiliki data pendapatan orang tua / jumlah tanggungan akan dilewati.
            </p>
        </div>

        {{-- Tabel siswa --}}
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skor Terakhir</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($siswa as $s)
                        @php $terakhir = $s->analisisPerilaku->first(); @endphp
                        <tr>
                            <td class="px-4 py-3">{{ $s->nis }}</td>
                            <td class="px-4 py-3">{{ $s->nama }}</td>
                            <td class="px-4 py-3">{{ $s->kelas }}</td>
                            <td class="px-4 py-3">{{ $terakhir?->skor ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if ($terakhir)
                                    <span @class([
                                        'px-2 py-1 rounded-full text-xs font-semibold',
                                        'bg-red-100 text-red-700' => $terakhir->kategori === 'Kurang',
                                        'bg-yellow-100 text-yellow-700' => $terakhir->kategori === 'Cukup',
                                        'bg-green-100 text-green-700' => $terakhir->kategori === 'Baik',
                                    ])>{{ $terakhir->kategori }}</span>
                                @else
                                    <span class="text-gray-400">Belum ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                @if ($terakhir)
                                    {{ $terakhir->periode_awal->format('d/m/Y') }} - {{ $terakhir->periode_akhir->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('analisis.show', $s->id) }}" class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $siswa->links() }}
        </div>
    </div>
</x-app-layout>