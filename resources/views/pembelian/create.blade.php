<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Daftar Produk
        </h2>
    </x-slot>

    <main class="py-4 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <form method="GET" action="{{ route('pembelian.create') }}" class="relative mb-4" id="search-form">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 
                            1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 
                            6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                </div>
                <input type="text" name="q" id="search-input" value="{{ request('q') }}"
                    placeholder="Cari nama produk..."
                    class="pl-10 pr-28 py-2 border rounded text-sm w-full focus:outline-none focus:ring focus:border-blue-300" />
                <button type="submit"
                    class="absolute right-0 top-0 bottom-0 bg-blue-500 text-white px-3 rounded-r hover:bg-blue-600 text-sm">
                    Cari
                </button>
            </form>

            {{-- Tabel Produk --}}
            @if($produk->count())
                <table class="table-auto w-full border text-sm" id="produkTable">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="border px-2 py-2">Nama Produk</th>
                            <th class="border px-2 py-1">Stok</th>
                            <th class="border px-2 py-1">Harga</th>
                            <th class="border px-2 py-1">Gambar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produk as $item)
                            <tr class="hover:bg-gray-100">
                                <td class="border px-2 py-1">{{ $item->nama }}</td>
                                <td class="border px-2 py-1 text-center">{{ $item->stok }}</td>
                                <td class="border px-2 py-1 text-left">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                <td class="border px-2 py-1 text-center">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" class="w-10 h-10 object-cover mx-auto">
                                    @else
                                        <span class="text-xs text-gray-500">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm text-gray-600">Tidak ada produk ditemukan.</p>
            @endif
        </div>
    </main>
</x-app-layout>
