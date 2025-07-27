<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white">Penjualan Produk</h2>
    </x-slot>

    <div class="py-3 max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Penjualan --}}
            <form action="{{ route('penjualan.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="produk_id" class="block text-sm font-medium text-gray-700">Produk</label>
                        <select name="produk_id" id="produk_id" class="mt-1 block w-full border rounded px-3 py-2" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($produk as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" min="1" class="mt-1 block w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="mt-1 block w-full border rounded px-3 py-2" required value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>

            {{-- Tabel Penjualan --}}
            <div class="mt-6">
                <h3 class="font-semibold text-lg mb-2">Riwayat Penjualan</h3>
                <table class="table-auto w-full border border-gray-300 rounded">
                    <thead class="bg-blue-700 text-white">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Produk</th>
                            <th class="px-4 py-2 border">Jumlah</th>
                            <th class="px-4 py-2 border">Total</th>
                            <th class="px-4 py-2 border">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualan as $i => $jual)
                            <tr class="text-center">
                                <td class="border px-4 py-2">{{ $i + 1 }}</td>
                                <td class="border px-4 py-2">{{ $jual->produk->nama }}</td>
                                <td class="border px-4 py-2">{{ $jual->jumlah }}</td>
                                <td class="border px-4 py-2">Rp{{ number_format($jual->total, 0, ',', '.') }}</td>
                                <td class="border px-4 py-2">{{ $jual->tanggal }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">Belum ada penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
