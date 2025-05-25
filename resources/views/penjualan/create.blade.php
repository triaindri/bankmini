<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Penjualan</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow mt-6">
        <form action="{{ route('penjualan.store') }}" method="POST">
            @csrf

            <div id="produk-list">
                <div class="flex space-x-4 mb-4">
                    <select name="produk_id[]" class="border rounded px-2 py-1 w-1/2">
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id }}">{{ $produk->nama }} (Rp{{ number_format($produk->harga) }})</option>
                        @endforeach
                    </select>
                    <input type="number" name="jumlah[]" min="1" placeholder="Jumlah" class="border rounded px-2 py-1 w-1/4">
                </div>
            </div>

            <button type="button" onclick="tambahProduk()" class="bg-gray-300 px-3 py-1 rounded text-sm">+ Produk</button>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Penjualan</button>
            </div>
        </form>
    </div>

    <script>
        function tambahProduk() {
            const container = document.getElementById('produk-list');
            const clone = container.children[0].cloneNode(true);
            container.appendChild(clone);
        }
    </script>
</x-app-layout>
