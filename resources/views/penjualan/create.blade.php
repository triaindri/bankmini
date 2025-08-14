<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Transaksi Penjualan</h2>
    </x-slot>

    <main class="py-3 max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('penjualan.store') }}">
                @csrf

                <!-- Produk Grid -->
                <label class="block mb-2 font-semibold">Pilih Produk</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mb-6">
                    @foreach($produk as $p)
                        <div 
                            class="produk-item border rounded-lg p-2 hover:bg-blue-100 cursor-pointer text-center"
                            data-id="{{ $p->id }}"
                            data-nama="{{ $p->nama }}"
                            data-harga="{{ $p->harga_jual }}"
                            onclick="handleClickProduk(this)">
                            @if($p->gambar)
                                <img src="{{ asset('storage/'.$p->gambar) }}" alt="{{ $p->nama }}" class="w-full h-24 object-cover rounded mb-2">
                            @else
                                <div class="w-full h-24 bg-gray-200 flex items-center justify-center rounded mb-2">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                            <span class="block font-medium">{{ $p->nama }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Keranjang -->
                <h3 class="font-semibold mb-2">Keranjang</h3>
                <table class="w-full border mb-4" id="tabel_keranjang">
                    <thead class="bg-blue-800 dark:bg-gray-700 text-white">
                        <tr>
                            <th class="border border-gray-300 px-2 py-1">Produk</th>
                            <th class="border border-gray-300 px-2 py-1 w-24">Jumlah</th>
                            <th class="border border-gray-300 px-2 py-1 w-16">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div class="text-left font-semibold text-lg mb-4">
                    Total Bayar: Rp <span id="total_bayar">0</span>
                </div>

                <!-- Form lainnya -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="w-full border rounded" value="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label>Metode Bayar</label>
                        <select name="metode_bayar" class="w-full border rounded">
                            <option value="cash">Cash</option>
                            <option value="tabungan">Tabungan</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label>Siswa (jika metode tabungan)</label>
                        <select name="siswa_id" class="w-full border rounded">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswa as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }} ({{ $s->kelas }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <x-primary-button>Proses</x-primary-button>
            </form>
        </div>
    </main>

    <script>
        const keranjang = {};

        function formatRupiah(angka) {
            return angka.toLocaleString('id-ID');
        }

        function handleClickProduk(el) {
            const id = el.dataset.id;
            const nama = el.dataset.nama;
            const harga = parseInt(el.dataset.harga);
            tambahKeKeranjang(id, nama, harga);
        }

        function tambahKeKeranjang(id, nama, harga) {
            const tbody = document.querySelector('#tabel_keranjang tbody');

            if (keranjang[id]) {
                let row = document.querySelector(`#row_${id}`);
                let qtyInput = row.querySelector('input[name="jumlah[]"]');
                qtyInput.value = parseInt(qtyInput.value) + 1;
            } else {
                keranjang[id] = harga;

                let tr = document.createElement('tr');
                tr.id = `row_${id}`;
                tr.innerHTML = `
                    <td class="border px-2 py-1">
                        ${nama}
                        <input type="hidden" name="produk_id[]" value="${id}">
                    </td>
                    <td class="border px-2 py-1">
                        <input type="number" name="jumlah[]" value="1" min="1" class="w-full border rounded" onchange="hitungTotalBayar()">
                    </td>
                    <td class="border px-2 py-1 text-center">
                        <button type="button" onclick="hapusProduk('${id}')" class="text-red-600 font-bold">X</button>
                    </td>
                `;
                tbody.appendChild(tr);
            }

            hitungTotalBayar();
        }

        function hapusProduk(id) {
            document.querySelector(`#row_${id}`).remove();
            delete keranjang[id];
            hitungTotalBayar();
        }

        function hitungTotalBayar() {
            let total = 0;
            for (let id in keranjang) {
                let row = document.querySelector(`#row_${id}`);
                if (row) {
                    let qty = parseInt(row.querySelector('input[name="jumlah[]"]').value);
                    total += keranjang[id] * qty;
                }
            }

            document.getElementById('total_bayar').textContent = formatRupiah(total);
        }
    </script>
</x-app-layout>
