<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Transaksi Penjualan</h2>
    </x-slot>

    <main class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('penjualan.store') }}">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label>Produk</label>
                        <select name="produk_id" class="w-full border rounded">
                            @foreach($produk as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="w-full border rounded" min="1" required>
                    </div>
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
</x-app-layout>
