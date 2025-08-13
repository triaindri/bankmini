<x-app-layout>
    <div class="flex min-h-screen bg-blue-900 text-white">
        {{-- Sidebar --}}
        <aside class="w-1/4 bg-blue-900 p-6 flex flex-col items-center">
            <img src="https://via.placeholder.com/100" class="rounded-full mb-4">
            <h2 class="text-lg font-bold">{{ $nama }}</h2>
            <p class="text-sm mb-6">{{ $email }}</p>
            <nav class="space-y-3 w-full">
                <a href="#" class="block p-2 rounded hover:bg-blue-800">Dashboard</a>
                <a href="#" class="block p-2 rounded hover:bg-blue-800">Riwayat Transaksi</a>
                <a href="#" class="block p-2 rounded hover:bg-blue-800">Daftar Produk</a>
                <a href="#" class="block p-2 rounded hover:bg-blue-800">Notifikasi</a>
            </nav>
            <div class="mt-auto w-full">
                <a href="#" class="block p-2 text-gray-300 hover:bg-blue-800">Pengaturan</a>
                <a href="{{ route('logout') }}" class="block p-2 text-red-400">Keluar</a>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 bg-blue-100 p-8 text-gray-900">
            <h1 class="text-xl font-bold">Halo, {{ $nama }}!</h1>
            <p class="mb-6">💰 Saldo tabungan Anda : Rp {{ number_format($saldo, 0, ',', '.') }}</p>
            <p class="text-sm mb-4">Hari ini : {{ $tanggal_hari_ini }}</p>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded p-4 shadow">
                    <p class="font-semibold">Setoran Bulan Ini</p>
                    <p class="text-2xl font-bold text-blue-800">Rp {{ number_format($setoran_bulan_ini, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded p-4 shadow">
                    <p class="font-semibold">Penarikan Bulan Ini</p>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($penarikan_bulan_ini, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-blue-200 rounded p-4 shadow">
                <p class="font-semibold text-red-600">📌 Transaksi Terakhir :</p>
                @foreach ($transaksi_terakhir as $transaksi)
                    <p>
                        {{ $transaksi['jenis'] }} :
                        Rp {{ number_format($transaksi['jumlah'], 0, ',', '.') }}
                        ( {{ $transaksi['tanggal'] }} )
                        @if(isset($transaksi['keterangan']))
                            - {{ $transaksi['keterangan'] }}
                        @endif
                    </p>
                @endforeach
            </div>
        </main>
    </div>
</x-app-layout>
