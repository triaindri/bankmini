<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Riwayat Penjualan</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-6 bg-white p-4 rounded shadow">
        @foreach ($penjualans as $penjualan)
            <div class="border-b py-4">
                <div class="font-semibold">Tanggal: {{ $penjualan->tanggal->format('d M Y') }} | Total: Rp{{ number_format($penjualan->total) }}</div>
                <ul class="text-sm ml-4 mt-1">
                    @foreach ($penjualan->details as $detail)
                        <li>• {{ $detail->produk->nama }} x {{ $detail->jumlah }} = Rp{{ number_format($detail->subtotal) }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</x-app-layout>
