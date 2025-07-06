<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl px-1 py-2 text-white leading-tight">Pembelian Produk</h2>
    </x-slot>

    <main class="py-3 max-w-5xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @if(session('success'))
                <div class="bg-green-100 text-blue-700 border border-green-300 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('pembelian.store') }}" method="POST" class="mb-6">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Produk</label>
                    <select name="produk_id" class="w-full rounded border-gray-300" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produk as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                        <option value="new">+ Tambah Produk Baru</option>
                    </select>
                </div>

                <div id="formProdukBaru" class="hidden">
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Nama Produk Baru</label>
                        <input type="text" name="nama_baru" value="{{ old('nama_baru') }}" class="w-full rounded border-gray-300">
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Harga Beli</label>
                        <input type="number" name="harga_beli" value="{{ old('harga_beli') }}" class="w-full rounded border-gray-300">
                    </div>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Harga Jual</label>
                        <input type="number" name="harga_jual" value="{{ old('harga_jual') }}" class="w-full rounded border-gray-300">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Jumlah Pembelian (Stok)</label>
                    <input type="number" name="jumlah" min="1" value="{{ old('jumlah') }}" class="w-full rounded border-gray-300" required>
                </div>

                <x-primary-button type="submit" class="bg-green-500 hover:bg-green-600">Simpan</x-primary-button>
            </form>

            {{-- Riwayat Pembelian --}}
            <h3 class="font-semibold text-lg mb-2">Riwayat Pembelian</h3>
            <table class="table-auto w-full border text-sm">
                <thead class="bg-blue-800 text-white">
                    <tr>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Produk</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembelian as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                            <td class="border px-4 py-2">{{ $item->produk->nama }}</td>
                            <td class="border px-4 py-2 text-center">{{ $item->jumlah }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

    @push('scripts')
    <script>
        const selectProduk = document.querySelector('select[name="produk_id"]');
        const formProdukBaru = document.getElementById('formProdukBaru');

        selectProduk.addEventListener('change', function () {
            formProdukBaru.classList.toggle('hidden', this.value !== 'new');
        });
    </script>
    @endpush
</x-app-layout>
